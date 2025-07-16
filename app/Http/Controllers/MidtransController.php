<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;
class MidtransController extends Controller
{
    /**
     * Endpoint untuk menerima notifikasi Midtrans
     */
    public function handleNotification(Request $request)
    {
        Log::info('Midtrans Notification', $request->all());

        $orderId = $request->order_id ?? null;
        $transactionStatus = $request->transaction_status ?? null;
        $grossAmount = $request->gross_amount ?? null;

        // Proses hanya kalau transaksi sukses
        if ($transactionStatus === 'settlement' && $orderId) {
            // Ambil id tagihan dari order_id (format: TAGIHAN-{id}-timestamp)
            $tagihanId = null;
            if (preg_match('/TAGIHAN-(\d+)-/', $orderId, $match)) {
                $tagihanId = $match[1];
            }

            if ($tagihanId) {
                $tagihan = Tagihan::find($tagihanId);

                if ($tagihan && $tagihan->status_tagihan != 'Sudah Dibayar') {
                    // Update status tagihan
                    $tagihan->update(['status_tagihan' => 'Sudah Dibayar']);

                    // Buat pembayaran jika belum ada
                    if (!$tagihan->pembayaran) {
                        Pembayaran::create([
                            'tagihan_id' => $tagihan->id,
                            'pelanggan_id' => $tagihan->pelanggan_id,
                            'user_id' => null,
                            'tanggal_pembayaran' => now(),
                            'biaya_admin' => 1000,
                            'total_bayar' => $grossAmount ?? $tagihan->total_tagihan,
                        ]);
                    }
                }
            }
        }

        // Wajib return HTTP 200
        return response()->json(['status' => 'ok']);
    }
}