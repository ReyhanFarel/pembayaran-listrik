<?php
// app/Models/Pelanggan.php
namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama_pelanggan', 'username', 'password', 'alamat', 'daya', 'id_tarif'];
    protected $hidden = ['password'];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
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
