<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $pembayarans = Pembayaran::with(['tagihan.pelanggan', 'user'])
                                ->orderBy('tanggal_pembayaran', 'desc')
                                ->paginate(10);

        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Tampilkan formulir untuk membuat pembayaran baru.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $tagihansBelumLunas = Tagihan::where('status_tagihan', 'Belum Dibayar')
                                    ->doesntHave('pembayaran')
                                    ->with('pelanggan.tarifs') // Load pelanggan dan tarifnya
                                    ->orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->get();

        return view('pembayaran.create', compact('tagihansBelumLunas'));
    }

    /**
     * Simpan pembayaran baru ke database.
     * Validasi input dan pastikan tagihan_id ada di tabel 'tagihan'.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
            'tanggal_pembayaran' => 'required|date|before_or_equal:today',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'tagihan_id.required' => 'Tagihan wajib dipilih.',
            'tagihan_id.exists' => 'Tagihan tidak valid.',
            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_pembayaran.date' => 'Format tanggal pembayaran tidak valid.',
            'tanggal_pembayaran.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan.',
            'biaya_admin.numeric' => 'Biaya admin harus berupa angka.',
            'biaya_admin.min' => 'Biaya admin tidak boleh negatif.',
        ]);

        DB::beginTransaction();
        try {
            $tagihan = Tagihan::with('pelanggan.tarifs')->find($validated['tagihan_id']);

            if (!$tagihan) {
                DB::rollBack();
                return back()->with('error', 'Tagihan tidak ditemukan.')->withInput();
            }

            if ($tagihan->status_tagihan == 'Sudah Dibayar') {
                DB::rollBack();
                return back()->with('error', 'Tagihan ini sudah lunas dan tidak dapat dibayar lagi.')->withInput();
            }

            $biayaAdmin = $validated['biaya_admin'] ?? 0;
            $totalTagihan = $tagihan->total_tagihan; // Menggunakan accessor
            $totalBayar = $totalTagihan + $biayaAdmin;

            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'pelanggan_id' => $tagihan->pelanggan_id,
                'user_id' => Auth::guard('web')->id(),
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'biaya_admin' => $biayaAdmin,
                'total_bayar' => $totalBayar,
            ]);

            $tagihan->update(['status_tagihan' => 'Sudah Dibayar']);

            DB::commit();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index')->with('success', 'Pembayaran berhasil dicatat dan status tagihan diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mencatat pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    
    public function show(Pembayaran $pembayaran)
    {
        return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index');
    }

   /**
     * Tampilkan formulir untuk mengedit pembayaran yang ada.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @param Pembayaran $pembayaran
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Pembayaran $pembayaran)
    {
        $pembayaran->load('tagihan.pelanggan.tarifs', 'user');
        return view('pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update Data pembayaran yang ada.
     * Validasi input dan pastikan tanggal pembayaran tidak di masa depan.
     * @param \Illuminate\Http\Request $request
     * @param Pembayaran $pembayaran
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'tanggal_pembayaran' => 'required|date|before_or_equal:today',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'tanggal_pembayaran.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_pembayaran.date' => 'Format tanggal pembayaran tidak valid.',
            'tanggal_pembayaran.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan.',
            'biaya_admin.numeric' => 'Biaya admin harus berupa angka.',
            'biaya_admin.min' => 'Biaya admin tidak boleh negatif.',
        ]);

        DB::beginTransaction();
        try {
            $tagihan = $pembayaran->tagihan->load('pelanggan.tarifs');
            $biayaAdmin = $validated['biaya_admin'] ?? 1000;// Default biaya admin jika tidak diisi
            $totalTagihan = $tagihan->total_tagihan;
            $totalBayar = $totalTagihan + $biayaAdmin;

            $pembayaran->update([
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'biaya_admin' => $biayaAdmin,
                'total_bayar' => $totalBayar,
            ]);

            DB::commit();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index')->with('success', 'Data pembayaran berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus pembayaran yang ada.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @param Pembayaran $pembayaran
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Pembayaran $pembayaran)
    {
        DB::beginTransaction();
        try {
            $tagihan = $pembayaran->tagihan;

            $pembayaran->delete();

            if ($tagihan) {
                $tagihan->update(['status_tagihan' => 'Belum Dibayar']);
            }

            DB::commit();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index')->with('success', 'Pembayaran berhasil dihapus dan status tagihan dikembalikan menjadi Belum Lunas!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index')->with('error', 'Terjadi kesalahan saat menghapus pembayaran: ' . $e->getMessage());
        }
    }

}