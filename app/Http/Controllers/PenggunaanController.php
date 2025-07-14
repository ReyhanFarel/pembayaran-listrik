<?php

namespace App\Http\Controllers;

use App\Models\Penggunaan;
use App\Models\Pelanggan; // Import Model Pelanggan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relasi 'pelanggan'
        $penggunaans = Penggunaan::with('pelanggan')
                            ->orderBy('tahun', 'desc')
                            ->orderBy('bulan', 'desc')
                            ->paginate(10); // Gunakan pagination untuk data yang banyak
       
        // Admin dan Petugas punya akses penuh di sini, jadi tidak perlu cek level_id
        // di dalam return view, middleware akan handle otorisasi akses ke controller ini
        return view('penggunaan.index', compact('penggunaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pelanggan untuk dropdown
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        return view('penggunaan.create', compact('pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|integer|digits:4',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gt:meter_awal', // meter_akhir harus lebih besar dari meter_awal
        ], [
            'pelanggan_id.required' => 'Pelanggan wajib dipilih.',
            'pelanggan_id.exists' => 'Pelanggan tidak valid.',
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit angka.',
            'meter_awal.required' => 'Meter awal wajib diisi.',
            'meter_awal.integer' => 'Meter awal harus angka.',
            'meter_awal.min' => 'Meter awal tidak boleh negatif.',
            'meter_akhir.required' => 'Meter akhir wajib diisi.',
            'meter_akhir.integer' => 'Meter akhir harus angka.',
            'meter_akhir.min' => 'Meter akhir tidak boleh negatif.',
            'meter_akhir.gt' => 'Meter akhir harus lebih besar dari meter awal.',
        ]);

        // Cek apakah data penggunaan untuk pelanggan, bulan, dan tahun yang sama sudah ada
        $existingPenggunaan = Penggunaan::where('pelanggan_id', $validated['pelanggan_id'])
                                        ->where('bulan', $validated['bulan'])
                                        ->where('tahun', $validated['tahun'])
                                        ->first();

        if ($existingPenggunaan) {
            return back()->withErrors([
                'bulan' => 'Data penggunaan untuk pelanggan ini pada bulan dan tahun tersebut sudah ada.'
            ])->withInput();
        }

        Penggunaan::create($validated);

        // Redirect berdasarkan siapa yang sedang login (Admin atau Petugas)
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
            return redirect()->route('admin.penggunaans.index')->with('success', 'Data penggunaan berhasil ditambahkan!');
        }
        return redirect()->route('petugas.penggunaans.index')->with('success', 'Data penggunaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penggunaan $penggunaan)
    {
        // Biasanya tidak diperlukan view show terpisah untuk CRUD sederhana
        return redirect()->route('admin.penggunaans.index'); // Atau petugas.penggunaans.index
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penggunaan $penggunaan)
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        return view('penggunaan.edit', compact('penggunaan', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penggunaan $penggunaan)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|integer|digits:4',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gt:meter_awal',
        ], [
            'pelanggan_id.required' => 'Pelanggan wajib dipilih.',
            'pelanggan_id.exists' => 'Pelanggan tidak valid.',
            'bulan.required' => 'Bulan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit angka.',
            'meter_awal.required' => 'Meter awal wajib diisi.',
            'meter_awal.integer' => 'Meter awal harus angka.',
            'meter_awal.min' => 'Meter awal tidak boleh negatif.',
            'meter_akhir.required' => 'Meter akhir wajib diisi.',
            'meter_akhir.integer' => 'Meter akhir harus angka.',
            'meter_akhir.min' => 'Meter akhir tidak boleh negatif.',
            'meter_akhir.gt' => 'Meter akhir harus lebih besar dari meter awal.',
        ]);

        // Cek apakah ada data penggunaan lain untuk pelanggan, bulan, dan tahun yang sama (kecuali dirinya sendiri)
        $existingPenggunaan = Penggunaan::where('pelanggan_id', $validated['pelanggan_id'])
                                        ->where('bulan', $validated['bulan'])
                                        ->where('tahun', $validated['tahun'])
                                        ->where('id', '!=', $penggunaan->id) // Abaikan dirinya sendiri
                                        ->first();

        if ($existingPenggunaan) {
            return back()->withErrors([
                'bulan' => 'Data penggunaan untuk pelanggan ini pada bulan dan tahun tersebut sudah ada.'
            ])->withInput();
        }

        $penggunaan->update($validated);

        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
            return redirect()->route('admin.penggunaans.index')->with('success', 'Data penggunaan berhasil diperbarui!');
        }
        return redirect()->route('petugas.penggunaans.index')->with('success', 'Data penggunaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penggunaan $penggunaan)
    {
        try {
            $penggunaan->delete();
            if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
                return redirect()->route('admin.penggunaans.index')->with('success', 'Data penggunaan berhasil dihapus!');
            }
            return redirect()->route('petugas.penggunaans.index')->with('success', 'Data penggunaan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani jika ada foreign key constraint (misal: penggunaan ini sudah punya tagihan)
            if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
                return redirect()->route('admin.penggunaans.index')->with('error', 'Tidak dapat menghapus data penggunaan ini karena memiliki tagihan terkait.');
            }
            return redirect()->route('petugas.penggunaans.index')->with('error', 'Tidak dapat menghapus data penggunaan ini karena memiliki tagihan terkait.');
        }
    }
}