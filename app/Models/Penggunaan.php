<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property int $id
 * @property int $pelanggan_id
 * @property string $bulan
 * @property int $tahun
 * @property int $meter_awal
 * @property int $meter_akhir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $jumlah_meter
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Tagihan|null $tagihan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereMeterAkhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereMeterAwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penggunaan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * Model Penggunaan
 *
 * Model ini merepresentasikan tabel 'penggunaan' yang menyimpan data penggunaan listrik oleh pelanggan.
 * Relasi:
 * - Pelanggan: Setiap penggunaan terkait dengan satu pelanggan.
 * - Tagihan: Setiap penggunaan dapat memiliki satu tagihan.
 */
class Penggunaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
    // Diperlukan karena nama tabel tidak sesuai dengan konvensi Laravel
    protected $table = 'penggunaan';

    /**
     * Atribut yang dapat diisi secara massal.
     * Ini adalah atribut yang dapat diisi melalui metode seperti create() atau update().
     *
     * @var array
     */
    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
    ];

    

    /**
     * Relasi ke Pelanggan
     * Setiap penggunaan terkait dengan satu pelanggan.
     *
     * @return BelongsTo
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class); // foreign key 'pelanggan_id' di tabel 'penggunaan'
    }

    /**
     * Relasi ke Tagihan
     * Setiap penggunaan dapat memiliki satu tagihan.
     *
     * @return HasOne
     */
    public function tagihan(): HasOne
    {
        return $this->hasOne(Tagihan::class); // foreign key 'penggunaan_id' di tabel 'tagihan'
    }

    /**
     * Accessor untuk menghitung jumlah meter yang digunakan.
     * Ini akan mengembalikan selisih antara meter akhir dan meter awal.
     *
     * @return int
     */
    public function getJumlahMeterAttribute()
    {
        return $this->meter_akhir - $this->meter_awal;
    }
}