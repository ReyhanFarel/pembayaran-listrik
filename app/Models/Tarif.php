<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property int $daya
 * @property numeric $tarif_perkwh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pelanggan> $pelanggans
 * @property-read int|null $pelanggans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif whereDaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif whereTarifPerkwh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tarif whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * Model Tarif
 *
 * Model ini merepresentasikan tabel 'tarif' yang menyimpan data tarif listrik.
 * Relasi:
 * - Pelanggan: Setiap tarif dapat dimiliki oleh banyak pelanggan.
 */
class Tarif extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
     protected $table = 'tarifs';

    /**
     * Atribut yang dapat diisi secara massal.
     * Ini adalah atribut yang dapat diisi melalui metode seperti create() atau update().
     * Pastikan hanya atribut yang aman untuk diisi yang dimasukkan di sini.
     * 
     * @var array
     */
    protected $fillable = ['daya', 'tarif_perkwh'];


    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Dalam hal ini, 'tarif_perkwh' akan di-cast menjadi desimal dengan 2 angka di belakang koma.
     *
     * @var array
     */
    protected $casts = ['tarif_perkwh' => 'decimal:2'];

    /**
     * Relasi ke Pelanggan
     * Relasi ini menghubungkan model Tarif dengan model Pelanggan.
     * Setiap tarif dapat dimiliki oleh banyak pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelanggans(): HasMany
    {
        return $this->hasMany(Pelanggan::class); // foreign key 'tarif_id' di tabel 'pelanggan'
    }
}