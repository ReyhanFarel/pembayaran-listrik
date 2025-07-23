<?php
// app/Models/Pelanggan.php
namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * Model Pelanggan
 * * @property int $id
 * @property string $nama_pelanggan
 * @property string $username
 * @property string $password
 * @property string $alamat
 * @property string $nomor_kwh
 * @property int $tarif_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tarif $tarifs
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penggunaan> $pengguna
 * @property-read int|null $pengguna_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tagihan> $tagihan
 * @property-read int|null $tagihan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pembayaran> $pembayaran
 * @property-read int|null $pembayaran_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNomorKwh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereTarifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUsername($value)
 * @mixin \Eloquent
 * 
 
 */
/**
 * Model Pelanggan
 *
 * Model ini merepresentasikan tabel 'pelanggan' yang menyimpan data pelanggan listrik.
 * Relasi:
 * - Tarif: Setiap pelanggan memiliki satu tarif.
 * - Penggunaan: Setiap pelanggan dapat memiliki banyak penggunaan.
 * - Tagihan: Setiap pelanggan dapat memiliki banyak tagihan.
 * - Pembayaran: Setiap pelanggan dapat memiliki banyak pembayaran.
 */
class Pelanggan extends Authenticatable
{
    use HasFactory;
    /**
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
    // Pastikan nama tabel sesuai dengan yang ada di database
    protected $table = 'pelanggan';
    /**
     * Atribut yang dapat diisi secara massal.
     * Ini adalah atribut yang dapat diisi melalui metode seperti create() atau update().
     *
     * @var array
     */
    protected $fillable = ['nama_pelanggan', 'username', 'password', 'alamat', 'nomor_kwh', 'tarif_id'];
    

    /**
    * Atrribut yang harus di hide ketika mengembalikan model.
    * Ini digunakan untuk menyembunyikan atribut sensitif seperti password dari hasil serialisasi model.
    *
    * @var array
    */
    protected $hidden = ['password'];


    /**
     * Relasi ke Tarif
     * Setiap pelanggan memiliki satu tarif.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tarifs()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id', 'id'); // foreign key 'tarif_id' di tabel 'pelanggan'
    }

    /**
     * Relasi ke Penggunaan
     * Setiap pelanggan dapat memiliki banyak penggunaan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengguna()
    {
        return $this->hasMany(Penggunaan::class);
    }
   

    /**
     * Relasi ke Tagihan
     * Setiap pelanggan dapat memiliki banyak tagihan.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function tagihan()
     {
         return $this->hasMany(Tagihan::class);
     }

    /**
     * Relasi ke Pembayaran
     * Setiap pelanggan dapat memiliki banyak pembayaran.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
   

}
