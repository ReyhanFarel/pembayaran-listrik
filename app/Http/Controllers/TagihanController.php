<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Tarif;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Tampilkan daftar tagihan.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        
        $tagihans = Tagihan::with(['pelanggan.tarifs', 'penggunaan'])
                            ->orderBy('tahun', 'desc')
                            ->orderBy('bulan', 'desc')
                            ->paginate(10);
                         

        return view('tagihan.index', compact('tagihans'));
    }

    /**
     * Tampilkan halaman untuk membuat tagihan baru dari penggunaan yang belum memiliki tagihan.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createFromPenggunaan()
    {
        $penggunaansBelumDitagih = Penggunaan::doesntHave('tagihan')
                                                ->with('pelanggan.tarifs')
                                                ->orderBy('tahun', 'desc')
                                                ->orderBy('bulan', 'desc')
                                                ->get();
        return view('tagihan.create_from_penggunaan', compact('penggunaansBelumDitagih'));
    }

    /**
     * Membuat tagihan baru berdasarkan penggunaan yang dipilih.
     * Validasi input untuk memastikan penggunaan_ids adalah array dan setiap id ada di tabel penggunaan.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'penggunaan_ids' => 'required|array',
            'penggunaan_ids.*' => 'exists:penggunaan,id',
        ], [
            'penggunaan_ids.required' => 'Pilih setidaknya satu data penggunaan untuk membuat tagihan.',
            'penggunaan_ids.*.exists' => 'Salah satu data penggunaan tidak valid.',
        ]);

        $countGenerated = 0;
        DB::beginTransaction();
        try {
            foreach ($validated['penggunaan_ids'] as $penggunaanId) {
                $penggunaan = Penggunaan::with('pelanggan.tarifs')->find($penggunaanId);

                if ($penggunaan && !$penggunaan->tagihan) {
                    $tarifPerKwh = optional($penggunaan->pelanggan->tarifs)->tarif_perkwh;

                    if ($tarifPerKwh === null) {
                        DB::rollBack();
                        return back()->with('error', 'Gagal membuat tagihan: Tarif untuk pelanggan ' . optional($penggunaan->pelanggan)->nama_pelanggan . ' (No. KWH: ' . optional($penggunaan->pelanggan)->nomor_kwh . ') tidak ditemukan. Harap pastikan tarif pelanggan sudah diatur.');
                    }

                    Tagihan::create([
                        'penggunaan_id' => $penggunaan->id,
                        'pelanggan_id' => $penggunaan->pelanggan_id,
                        'jumlah_meter' => $penggunaan->meter_akhir - $penggunaan->meter_awal,
                        'bulan' => $penggunaan->bulan,
                        'tahun' => $penggunaan->tahun,
                        'status_tagihan' => 'Belum Dibayar',
                    ]);
                    $countGenerated++;
                }
            }
            DB::commit();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.tagihans.index' : 'petugas.tagihans.index')->with('success', $countGenerated . ' tagihan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat tagihan: ' . $e->getMessage())->withInput();
        }
    }


   
    public function show(Tagihan $tagihan)
    {
        return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.tagihans.index' : 'petugas.tagihans.index');
    }

    /**
     * Tampilkan formulir untuk mengedit tagihan yang ada.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @param Tagihan $tagihan
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Tagihan $tagihan)
    {
        $tagihan->load('pelanggan.tarifs', 'penggunaan');
        return view('tagihan.edit', compact('tagihan'));
    }

    /**
     * Update Data tagihan yang ada.
     * Validasi input untuk memastikan status_tagihan adalah 'Belum Dibayar' atau 'Sudah Dibayar'.
     * @param \Illuminate\Http\Request $request
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        $validated = $request->validate([
            'status_tagihan' => 'required|in:Belum Dibayar,Sudah Dibayar',
        ], [
            'status_tagihan.required' => 'Status tagihan wajib diisi.',
            'status_tagihan.in' => 'Status tagihan tidak valid.',
        ]);

        $tagihan->update($validated);

        return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.tagihans.index' : 'petugas.tagihans.index')->with('success', 'Status tagihan berhasil diperbarui menjadi ' . $tagihan->status_tagihan . '!');
    }

    /**
     * Hapus tagihan yang ada.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Tagihan $tagihan)
    {
        try {
            $tagihan->delete();
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.tagihans.index' : 'petugas.tagihans.index')->with('success', 'Tagihan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route(Auth::guard('web')->user()->level_id == 1 ? 'admin.tagihans.index' : 'petugas.tagihans.index')->with('error', 'Tidak dapat menghapus tagihan ini karena sudah memiliki data pembayaran terkait.');
        }
    }
}