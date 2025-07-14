<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan'; // Pastikan nama tabel benar
    protected $fillable = [
        'id_penggunaan',
        'jumlah_meter',
        'bulan', // Tambahkan 'bulan' dan 'tahun' ke fillable
        'tahun',
        'status_tagihan',
    ];

    // Pastikan casting jika 'bulan' dan 'tahun' disimpan sebagai tipe data non-string/non-integer
    protected $casts = [
        'bulan' => 'string',
        'tahun' => 'integer',
    ];

    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class);
    }
 public function pelanggan() // Relasi baru ke pelanggan
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}