<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $tagihan_id
 * @property int $pelanggan_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $tanggal_pembayaran
 * @property numeric $biaya_admin
 * @property numeric $total_bayar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Tagihan $tagihan
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereBiayaAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTagihanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTotalBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUserId($value)
 * @mixin \Eloquent
 */
/**
 * Model Pembayaran
 *
 * Model ini merepresentasikan tabel 'pembayaran' yang menyimpan data pembayaran tagihan listrik.
 * Relasi:
 * - Tagihan: Setiap pembayaran terkait dengan satu tagihan.
 * - Pelanggan: Setiap pembayaran terkait dengan satu pelanggan.
 * - User: Admin/Petugas yang mencatat pembayaran.
 */
class Pembayaran extends Model
{
    use HasFactory;
    /**
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
    // Pastikan nama tabel sesuai dengan yang ada di database
    protected $table = 'pembayaran'; 
    /**
     * Atribut yang dapat diisi secara massal.
     * Ini adalah atribut yang dapat diisi melalui metode seperti create() atau update().
     *
     * @var array
     */
    protected $fillable = [
        'tagihan_id',
        'pelanggan_id',
        'user_id', 
        'tanggal_pembayaran',
        'biaya_admin',
        'total_bayar',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Dalam hal ini, 'tanggal_pembayaran' akan di-cast menjadi tanggal,
     * 'biaya_admin' dan 'total_bayar' akan di-cast menjadi desimal dengan 2 angka di belakang koma.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'biaya_admin' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];


    /**
     * Relasi ke Model Tagihan
     * Setiap pembayaran terkait dengan satu tagihan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // Relasi ke Model Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }


    /**
     * Relasi ke Model Pelanggan
     * Setiap pembayaran terkait dengan satu pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // Relasi ke Model Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Relasi ke Model User (Admin/Petugas yang mencatat)
     * Setiap pembayaran dapat dicatat oleh satu user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // Relasi ke Model User (Admin/Petugas yang mencatat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}