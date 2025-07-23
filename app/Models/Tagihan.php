<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $penggunaan_id
 * @property int $pelanggan_id
 * @property string $bulan
 * @property int $tahun
 * @property int $jumlah_meter
 * @property string $status_tagihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $tarif_data
 * @property-read mixed $total_tagihan
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Pembayaran|null $pembayaran
 * @property-read \App\Models\Penggunaan $penggunaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereJumlahMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan wherePenggunaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereStatusTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * Model Tagihan
 *
 * Model ini merepresentasikan tabel 'tagihan' yang menyimpan data tagihan listrik.
 * Relasi:
 * - Penggunaan: Setiap tagihan terkait dengan satu penggunaan.
 * - Pelanggan: Setiap tagihan terkait dengan satu pelanggan.
 * - Pembayaran: Setiap tagihan dapat memiliki satu pembayaran.
 */
class Tagihan extends Model
{
    use HasFactory;

    /** 
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
    protected $table = 'tagihan';


    /**
     * Atribut yang dapat diisi secara massal.
     * Ini digunakan untuk menghindari mass assignment vulnerability.
     *
     * @var array
     */
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

    /**
     * Relasi ke Penggunaan
     * Setiap tagihan terkait dengan satu penggunaan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class);
    }

    /**
     * Relasi ke Pelanggan
     * Setiap tagihan terkait dengan satu pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Relasi ke Pembayaran
     * Setiap tagihan dapat memiliki satu pembayaran.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    // Accessor untuk mendapatkan objek Tarif melalui relasi pelanggan

    /**
     * Accessor untuk mendapatkan data tarif dari relasi pelanggan.
     * Ini akan mengembalikan tarif yang terkait dengan pelanggan yang memiliki tagihan ini.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getTarifDataAttribute()
    {
        return optional($this->pelanggan)->tarifs;
    }


    /**
     * Accessor untuk menghitung total tagihan berdasarkan jumlah meter dan tarif per kWh.
     * Ini akan mengembalikan total tagihan yang dihitung secara dinamis.
     *
     * @return float
     */
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