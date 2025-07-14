<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran'; // Pastikan nama tabel benar
    protected $fillable = [
        'tagihan_id',
        'pelanggan_id',
        'user_id', // Admin/Petugas yang mencatat pembayaran
        'tanggal_pembayaran',
        'biaya_admin',
        'total_bayar',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'biaya_admin' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];

    // Relasi ke Model Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    // Relasi ke Model Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke Model User (Admin/Petugas yang mencatat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}