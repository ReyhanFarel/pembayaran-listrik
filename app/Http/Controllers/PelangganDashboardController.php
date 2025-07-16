<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pelanggan;

class PelangganDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama pelanggan.
     */
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        $lastPenggunaan = Penggunaan::where('pelanggan_id', $pelanggan->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        $lastUnpaidTagihan = Tagihan::where('pelanggan_id', $pelanggan->id)
            ->where('status_tagihan', 'Belum Dibayar')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        return view('pelanggan.dashboard', compact('pelanggan', 'lastPenggunaan', 'lastUnpaidTagihan'));
    }

    /**
     * Menampilkan daftar tagihan pelanggan dengan searching/sorting.
     */
    public function tagihanSaya(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        // Jika ada parameter success_id, update status tagihan & buat pembayaran
        if ($request->has('success_id')) {
            $tagihan = Tagihan::where('id', $request->success_id)
                ->where('pelanggan_id', $pelanggan->id)
                ->first();
            if ($tagihan && $tagihan->status_tagihan != 'Sudah Dibayar') {
                $tagihan->update(['status_tagihan' => 'Sudah Dibayar']);
                if (!$tagihan->pembayaran) {
                    Pembayaran::create([
                        'tagihan_id' => $tagihan->id,
                        'pelanggan_id' => $tagihan->pelanggan_id,
                        'user_id' => null,
                        'tanggal_pembayaran' => now(),
                        'biaya_admin' => 1000,
                        'total_bayar' => $tagihan->total_tagihan,
                    ]);
                }
            }
        }

        $query = Tagihan::where('pelanggan_id', $pelanggan->id);
            

        // Searching
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('bulan', 'like', "%$q%")
                    ->orWhere('tahun', 'like', "%$q%")
                    ->orWhere('status_tagihan', 'like', "%$q%");
            });
        }

        // Sorting
        $sort = $request->sort === 'tahun' ? 'tahun' : 'created_at'; // default tahun, fallback created_at
        $direction = $request->direction === 'asc' ? 'asc' : 'desc'; // default desc

        $query->orderBy($sort, $direction);

        $tagihans = $query->paginate(10)->appends($request->all());

        return view('pelanggan.tagihan_saya', compact('pelanggan', 'tagihans'));
    }

    /**
     * Menampilkan riwayat pembayaran pelanggan dengan searching/sorting.
     */
  public function riwayatPembayaran(Request $request)
{
    $pelanggan = Auth::guard('pelanggan')->user();

    if (!$pelanggan) {
        return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
    }

    $query = Pembayaran::where('pelanggan_id', $pelanggan->id)
        ->with(['tagihan', 'user']);

    // Searching
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function($sub) use ($q) {
            // Bulan/tahun tagihan
            $sub->orWhereHas('tagihan', function($q2) use ($q) {
                $q2->where('bulan', 'like', "%$q%")
                   ->orWhere('tahun', 'like', "%$q%");
            });
            // Total bayar (angka, bisa LIKE atau =)
            if (is_numeric($q)) {
                $sub->orWhere('total_bayar', '=', $q)
                    ->orWhereRaw('CAST(total_bayar AS CHAR) LIKE ?', ["%$q%"]);
            } else {
                $sub->orWhereRaw('CAST(total_bayar AS CHAR) LIKE ?', ["%$q%"]);
            }
        });
    }

    // Sorting
    $allowedSorts = ['tanggal_pembayaran', 'total_bayar'];
    $sort = in_array($request->sort, $allowedSorts) ? $request->sort : 'tanggal_pembayaran';
    $direction = $request->direction === 'asc' ? 'asc' : 'desc';

    $query->orderBy($sort, $direction);

    $riwayatPembayaran = $query->paginate(10)->appends($request->all());

    return view('pelanggan.riwayat_pembayaran', compact('pelanggan', 'riwayatPembayaran'));
}

    /**
     * Menampilkan halaman profil pelanggan.
     */
    public function profilSaya()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }
        $pelanggan->load('tarifs'); // Load relasi tarifs untuk menampilkan daya

        return view('pelanggan.profil_saya', compact('pelanggan'));
    }

    /**
     * Memperbarui profil (khususnya password) pelanggan.
     */
    public function updateProfil(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        $rules = [
            'nama_pelanggan' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:100', Rule::unique('pelanggan')->ignore($pelanggan->id)],
            'alamat' => 'required|string|max:200',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $validated = $request->validate($rules, [
            'nama_pelanggan.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh pelanggan lain.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $pelanggan->nama_pelanggan = $validated['nama_pelanggan'];
        $pelanggan->username = $validated['username'];
        $pelanggan->alamat = $validated['alamat'];

        if ($request->filled('password')) {
            $pelanggan->password = Hash::make($validated['password']);
        }

        $pelanggan->save();

        return redirect()->route('pelanggan.profil_saya')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Proses Bayar Tagihan (Midtrans)
     */
    public function bayarTagihan(Request $request, $id)
    {
        $tagihan = Tagihan::with('pelanggan')->findOrFail($id);

        if ($tagihan->status_tagihan == 'Sudah Dibayar') {
            return back()->with('error', 'Tagihan sudah dibayar.');
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'TAGIHAN-' . $tagihan->id . '-' . time(),
                'gross_amount' => $tagihan->total_tagihan,
            ],
            'customer_details' => [
                'first_name' => $tagihan->pelanggan->nama_pelanggan,
            ],
            'item_details' => [
                [
                    'id' => $tagihan->id,
                    'price' => $tagihan->total_tagihan,
                    'quantity' => 1,
                    'name' => "Tagihan Listrik {$tagihan->bulan}/{$tagihan->tahun}"
                ]
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('pelanggan.midtrans_bayar', compact('tagihan', 'snapToken'));
    }

    /**
     * Menampilkan riwayat penggunaan listrik pelanggan (tanpa searching & sorting)
     */
    public function riwayatPenggunaan(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        $riwayatPenggunaan = Penggunaan::where('pelanggan_id', $pelanggan->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(10);

        return view('pelanggan.riwayat_penggunaan', compact('pelanggan', 'riwayatPenggunaan'));
    }
}