<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with(['tagihan.pelanggan', 'user'])
                                ->orderBy('tanggal_pembayaran', 'desc')
                                ->paginate(10);

        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
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

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.pembayarans.index' : 'petugas.pembayarans.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $pembayaran->load('tagihan.pelanggan.tarifs', 'user');
        return view('pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update the specified resource in storage.
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
            $biayaAdmin = $validated['biaya_admin'] ?? 0;
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
     * Remove the specified resource from storage.
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