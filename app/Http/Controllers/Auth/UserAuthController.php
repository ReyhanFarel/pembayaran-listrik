<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan; // Pastikan model Pelanggan sudah ada
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            // --- Lakukan eager loading relasi 'level' di sini ---
            // Ambil ulang user yang baru saja login, beserta relasi level-nya
            $user = Auth::guard('web')->user()->load('level'); 

            if ($user->level_id == 1) { // Asumsi level_id 1 untuk Admin
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->level_id == 2) { // Asumsi level_id 2 untuk Petugas
                return redirect()->intended('/petugas/dashboard');
            }
            return redirect()->intended('/admin/dashboard');
        }

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/pelanggan/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

     public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:100', 'unique:pelanggan,username'],
            'password' => 'required|string|min:6|confirmed', // 'confirmed' butuh password_confirmation
            'alamat' => 'required|string|max:200',
            'nomor_kwh' => ['required', 'string', 'max:50', 'unique:pelanggan,nomor_kwh'],
            'tarif_id' => 'required|exists:tarifs,id', // Pastikan tarif_id ada di tabel 'tarifs'
        ], [
            'nama_pelanggan.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nomor_kwh.required' => 'Nomor KWH wajib diisi.',
            'nomor_kwh.unique' => 'Nomor KWH ini sudah terdaftar.',
            'tarif_id.required' => 'Tarif listrik wajib dipilih.',
            'tarif_id.exists' => 'Tarif listrik tidak valid.',
        ]);

        // Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        // Buat pelanggan baru
        $pelanggan = Pelanggan::create($validated);

        // Langsung login sebagai pelanggan yang baru terdaftar
        Auth::guard('pelanggan')->login($pelanggan);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $pelanggan->nama_pelanggan);
    }
  public function showRegistrationForm()
    {
        $tarifs = Tarif::orderBy('daya')->get(); // Ambil semua tarif untuk dropdown
        return view('auth.register', compact('tarifs'));
    }
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}