<?php
// app/Models/Pelanggan.php
namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama_pelanggan', 'username', 'password', 'alamat', 'nomor_kwh', 'tarif_id'];
    protected $hidden = ['password'];

    public function tarifs()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id', 'id'); // foreign key 'tarif_id' di tabel 'pelanggan'
    }
        public function pengguna()
    {
        return $this->hasMany(Penggunaan::class);
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
