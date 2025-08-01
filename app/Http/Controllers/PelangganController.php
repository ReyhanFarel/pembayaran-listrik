<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Tampilkan daftar pelanggan.
     * Hanya Admin dan Petugas yang dapat mengaksesnya.
     * Admin dapat melihat semua pelanggan, Petugas hanya dapat melihat pelanggan.
     */
    public function index()
    {
        $pelanggans = Pelanggan::with('tarifs')->orderBy('nama_pelanggan')->paginate(10) ;
   
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) { // Admin
            return view('admin.pelanggans.index', compact('pelanggans'));
        } elseif (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 2) { // Petugas
            return view('petugas.pelanggans.index', compact('pelanggans'));
        }
        abort(403, 'Akses tidak diizinkan untuk melihat data pelanggan.');
    }

    /**
     * Tampilkan formulir untuk membuat pelanggan baru.
     * Hanya Admin yang dapat mengaksesnya.
     * Jika bukan Admin, akan mengembalikan error 403.
     */
    public function create()
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) { // Hanya Admin
            $tarifs = Tarif::orderBy('daya')->get();
            return view('admin.pelanggans.create', compact('tarifs'));
        }
        abort(403, 'Akses Dilarang. Hanya Admin yang dapat menambah pelanggan.');
    }

    /**
     * Simpan pelanggan baru ke database.
     * Validasi input dan pastikan tarif_id ada di tabel 'tarifs'.
     * Hanya Admin yang dapat menyimpan pelanggan.
     * Jika bukan Admin, akan mengembalikan error 403.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat menyimpan pelanggan.');
        }

        $validated = $request->validate([
            'tarif_id' => 'required|exists:tarifs,id', // Pastikan tarif_id ada di tabel 'tarifs' (jamak)
            'nama_pelanggan' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:pelanggan,username',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string|max:200',
            'nomor_kwh' => 'required|string|max:50|unique:pelanggan,nomor_kwh', // <-- Ganti 'daya'
        ], [
            'tarif_id.required' => 'Tarif listrik wajib dipilih.',
            'tarif_id.exists' => 'Tarif listrik tidak valid.',
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nomor_kwh.required' => 'Nomor KWH wajib diisi.', // <-- Ganti pesan
            'nomor_kwh.string' => 'Nomor KWH harus berupa teks.', // <-- Ganti pesan
            'nomor_kwh.max' => 'Nomor KWH maksimal :max karakter.', // <-- Ganti pesan
            'nomor_kwh.unique' => 'Nomor KWH ini sudah terdaftar.', // <-- Ganti pesan
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Pelanggan::create($validated);

        return redirect()->route('admin.pelanggans.index')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir untuk mengedit pelanggan yang ada.
     * Hanya Admin yang dapat mengaksesnya.
     * Jika bukan Admin, akan mengembalikan error 403.
     */
    public function edit(Pelanggan $pelanggan)
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1) {
            $tarifs = Tarif::orderBy('daya')->get();
            return view('admin.pelanggans.edit', compact('pelanggan', 'tarifs'));
        }
        abort(403, 'Akses Dilarang. Hanya Admin yang dapat mengedit pelanggan.');
    }

    /**
     * Update Data pelanggan yang ada.
     * Validasi input dan pastikan tarif_id ada di tabel 'tarifs'.
     * Hanya Admin yang dapat memperbarui pelanggan.
     * Jika bukan Admin, akan mengembalikan error 403.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat memperbarui pelanggan.');
        }

        $rules = [
            'tarif_id' => 'required|exists:tarifs,id',
            'nama_pelanggan' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:pelanggan,username,' . $pelanggan->id,
            'alamat' => 'required|string|max:200',
            'nomor_kwh' => 'required|string|max:50|unique:pelanggan,nomor_kwh,' . $pelanggan->id, // <-- Ganti 'daya'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        $validated = $request->validate($rules, [
            'tarif_id.required' => 'Tarif listrik wajib dipilih.',
            'tarif_id.exists' => 'Tarif listrik tidak valid.',
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nomor_kwh.required' => 'Nomor KWH wajib diisi.', // <-- Ganti pesan
            'nomor_kwh.string' => 'Nomor KWH harus berupa teks.', // <-- Ganti pesan
            'nomor_kwh.max' => 'Nomor KWH maksimal :max karakter.', // <-- Ganti pesan
            'nomor_kwh.unique' => 'Nomor KWH ini sudah terdaftar.', // <-- Ganti pesan
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggans.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Hapus pelanggan yang ada.
     * Hanya Admin yang dapat menghapus pelanggan.
     * Jika bukan Admin, akan mengembalikan error 403.
     * @param \App\Models\Pelanggan $pelanggan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pelanggan $pelanggan)
    {
        if (!Auth::guard('web')->check() || Auth::guard('web')->user()->level_id != 1) {
            abort(403, 'Akses Dilarang. Hanya Admin yang dapat menghapus pelanggan.');
        }

        try {
            $pelanggan->delete();
            return redirect()->route('admin.pelanggans.index')->with('success', 'Data pelanggan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pelanggans.index')->with('error', 'Tidak dapat menghapus pelanggan ini karena memiliki data terkait (penggunaan, tagihan, dll).');
        }
    }
}