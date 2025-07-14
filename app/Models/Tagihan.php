<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    protected $fillable = [
        'penggunaan_id',
        'pelanggan_id',
        'jumlah_meter',
        'bulan',
        'tahun',
        'status_tagihan',
    ];

    // Hapus cast untuk 'jumlah_bayar'
    // protected $casts = [
    //     'jumlah_bayar' => 'decimal:2',
    // ];

    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke Pembayaran (penting untuk fitur ini)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    // Accessor untuk mendapatkan objek Tarif melalui relasi pelanggan
    public function getTarifDataAttribute()
    {
        return optional($this->pelanggan)->tarif;
    }

    // Accessor untuk menghitung total tagihan secara dinamis
    public function getTotalTagihanAttribute()
    {
        $tarifPerKwh = optional($this->pelanggan->tarifs)->tarif_perkwh;

        if ($tarifPerKwh === null) {
            return 0;
        }

        return $this->jumlah_meter * $tarifPerKwh;
    }
}