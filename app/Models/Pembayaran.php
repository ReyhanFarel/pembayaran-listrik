<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'pelanggan_id',
        'user_id',
        'tanggal_pembayaran',
        'biaya_admin',
        'total_bayar',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'biaya_admin' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class); // foreign key 'tagihan_id' di tabel 'pembayaran'
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class); // foreign key 'pelanggan_id' di tabel 'pembayaran'
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // foreign key 'user_id' di tabel 'pembayaran'
    }
}