<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran; // Untuk detail pembayaran di tagihan saya

class PelangganDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama pelanggan.
     */
    public function index()
    {
        // Ambil objek pelanggan yang sedang login dari guard 'pelanggan'
        $pelanggan = Auth::guard('pelanggan')->user();

        // Pastikan $pelanggan tidak null sebelum mengakses propertinya
        if (!$pelanggan) {
            // Ini seharusnya tidak terjadi jika middleware 'auth:pelanggan' berfungsi,
            // tapi sebagai fallback keamanan.
            return redirect()->route('pelanggan.login')->with('error', 'Sesi Anda telah berakhir.');
        }

        // Ambil penggunaan terakhir untuk ringkasan dashboard
        $lastPenggunaan = Penggunaan::where('pelanggan_id', $pelanggan->id)
                                    ->orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        // Ambil tagihan terakhir yang belum lunas (jika ada)
        $lastUnpaidTagihan = Tagihan::where('pelanggan_id', $pelanggan->id)
                                    ->where('status_tagihan', 'Belum Lunas')
                                    ->orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        // Kirim variabel $pelanggan ke view
        return view('pelanggan.dashboard', compact('pelanggan', 'lastPenggunaan', 'lastUnpaidTagihan'));
    }

    /**
     * Menampilkan riwayat penggunaan listrik pelanggan.
     */
    public function riwayatPenggunaan()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

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

        // Eager load relasi yang dibutuhkan: penggunaan untuk detail meteran, dan pembayaran jika sudah lunas
        $tagihans = Tagihan::where('pelanggan_id', $pelanggan->id)
                            ->with(['penggunaan', 'pembayaran.user']) // Load penggunaan dan pembayaran beserta user yang mencatat
                            ->orderBy('tahun', 'desc')
                            ->orderBy('bulan', 'desc')
                            ->paginate(10);

        return view('pelanggan.tagihan_saya', compact('pelanggan', 'tagihans'));
    }
}