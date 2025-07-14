<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penggunaan extends Model
{
    use HasFactory;

    protected $table = 'penggunaan';

    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class); // foreign key 'pelanggan_id' di tabel 'penggunaan'
    }

    public function tagihan(): HasOne
    {
        return $this->hasOne(Tagihan::class); // foreign key 'penggunaan_id' di tabel 'tagihan'
    }
     public function getJumlahMeterAttribute()
    {
        return $this->meter_akhir - $this->meter_awal;
    }
}