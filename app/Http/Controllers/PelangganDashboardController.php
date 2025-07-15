<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran; // Pastikan model Pembayaran diimport
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
                                    ->where('status_tagihan', 'Belum Lunas')
                                    ->orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        return view('pelanggan.dashboard', compact('pelanggan', 'lastPenggunaan', 'lastUnpaidTagihan'));
    }

    /**
     * Menampilkan riwayat penggunaan listrik pelanggan.
     */
    public function riwayatPenggunaan()
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

    /**
     * Menampilkan daftar tagihan pelanggan.
     */
    public function tagihanSaya()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        $tagihans = Tagihan::where('pelanggan_id', $pelanggan->id)
                            ->with(['penggunaan', 'pembayaran.user'])
                            ->orderBy('tahun', 'desc')
                            ->orderBy('bulan', 'desc')
                            ->paginate(10);

        return view('pelanggan.tagihan_saya', compact('pelanggan', 'tagihans'));
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
     * Menampilkan riwayat pembayaran pelanggan.
     */
    public function riwayatPembayaran()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pelanggan.');
        }

        // Eager load relasi tagihan dan user (yang mencatat pembayaran)
        $riwayatPembayaran = Pembayaran::where('pelanggan_id', $pelanggan->id)
                                        ->with(['tagihan', 'user'])
                                        ->orderBy('tanggal_pembayaran', 'desc')
                                        ->paginate(10);

        return view('pelanggan.riwayat_pembayaran', compact('pelanggan', 'riwayatPembayaran'));
    }
}