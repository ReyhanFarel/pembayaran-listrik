<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk cek level di controller

class TarifController extends Controller
{
    /**
     * Daftar tarif yang tersedia.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $tarifs = Tarif::orderBy('daya')->get();

        // Tentukan view berdasarkan level pengguna yang login
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->level_id == 1) { // Admin
                return view('admin.tarifs.index', compact('tarifs'));
            } elseif (Auth::guard('web')->user()->level_id == 2) { // Petugas
                return view('petugas.tarifs.index', compact('tarifs'));
            }
        }
        // Fallback jika ada akses aneh tanpa level yang jelas (seharusnya diatasi middleware)
        abort(403, 'Akses tidak diizinkan untuk melihat tarif.');
    }

    /**
     * Tampilkan formulir untuk membuat tarif baru.
     * Hanya Admin yang dapat mengaksesnya.
     * @return \Illuminate\View\View    
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        // Hanya Admin yang bisa mengakses halaman create
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
            return view('admin.tarifs.create');
        }
        abort(403, 'Akses Dilarang. Hanya Admin yang dapat menambah tarif.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan hanya Admin yang bisa melakukan store
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat menyimpan tarif.');
        }

        $validated = $request->validate([
            'daya' => 'required|integer|min:100|unique:tarifs,daya',
            'tarif_perkwh' => 'required|numeric|min:0',
        ], [
            'daya.required' => 'Daya wajib diisi.',
            'daya.integer' => 'Daya harus berupa angka.',
            'daya.min' => 'Daya minimal :min.',
            'daya.unique' => 'Daya ini sudah terdaftar.',
            'tarif_perkwh.required' => 'Tarif per kWh wajib diisi.',
            'tarif_perkwh.numeric' => 'Tarif per kWh harus berupa angka.',
            'tarif_perkwh.min' => 'Tarif per kWh tidak boleh negatif.',
        ]);

        Tarif::create($validated);

        return redirect()->route('admin.tarifs.index')->with('success', 'Data tarif berhasil ditambahkan!');
    }

    /**
     * Tampilkan halaman untuk mengedit tarif yang ada.
     * Hanya Admin yang dapat mengaksesnya.
     * @param Tarif $tarif
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Tarif $tarif)
    {
        // Hanya Admin yang bisa mengakses halaman edit
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
            return view('admin.tarifs.edit', compact('tarif'));
        }
        abort(403, 'Akses Dilarang. Hanya Admin yang dapat mengedit tarif.');
    }

    /**
     * Update Data tarif yang ada.
     * Validasi input untuk memastikan daya unik dan tarif_perkwh valid.
     * Hanya Admin yang dapat memperbarui tarif.
     * @param \Illuminate\Http\Request $request
     * @param Tarif $tarif
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Tarif $tarif)
    {
        // Pastikan hanya Admin yang bisa melakukan update
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat memperbarui tarif.');
        }

        $validated = $request->validate([
            'daya' => 'required|integer|min:100|unique:tarifs,daya,' . $tarif->id,
            'tarif_perkwh' => 'required|numeric|min:0',
        ], [
            'daya.required' => 'Daya wajib diisi.',
            'daya.integer' => 'Daya harus berupa angka.',
            'daya.min' => 'Daya minimal :min.',
            'daya.unique' => 'Daya ini sudah terdaftar.',
            'tarif_perkwh.required' => 'Tarif per kWh wajib diisi.',
            'tarif_perkwh.numeric' => 'Tarif per kWh harus berupa angka.',
            'tarif_perkwh.min' => 'Tarif per kWh tidak boleh negatif.',
        ]);

        $tarif->update($validated);

        return redirect()->route('admin.tarifs.index')->with('success', 'Data tarif berhasil diperbarui!');
    }

    /**
     * Hapus tarif yang ada.
     * Hanya Admin yang dapat mengaksesnya.
     * @param Tarif $tarif
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Tarif $tarif)
    {
        // Pastikan hanya Admin yang bisa melakukan destroy
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat menghapus tarif.');
        }

        $tarif->delete();
        return redirect()->route('admin.tarifs.index')->with('success', 'Data tarif berhasil dihapus!');
    }
}