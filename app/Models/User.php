<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Pastikan nama tabel benar
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'level_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}