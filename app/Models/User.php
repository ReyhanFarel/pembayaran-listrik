<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property int $id
 * @property string $nama_user
 * @property string $username
 * @property string $password
 * @property int|null $level_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Level|null $level
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pembayaran> $pembayaran
 * @property-read int|null $pembayaran_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNamaUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @mixin \Eloquent
 */
/**
 * Model User
 *
 * Model ini merepresentasikan tabel 'users' yang menyimpan data pengguna sistem.
 * Relasi:
 * - Level: Setiap pengguna memiliki satu level (Admin/Petugas).
 * - Pembayaran: Setiap pengguna dapat mencatat banyak pembayaran.
 */ 
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Pastikan nama tabel sesuai dengan yang ada di database.
     * Jika nama tabel berbeda, Anda perlu mengubahnya di sini.
     * 
     * @var string
     */
    protected $table = 'users'; 
    /**
     * Atribut yang dapat diisi secara massal.
     * Pastikan atribut ini sesuai dengan kolom yang ada di tabel 'users'.
     * 
     * @var array
     */
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'level_id',
    ];

    /**
     * Atribut yang harus disembunyikan saat model diubah menjadi array atau JSON.
     * Biasanya digunakan untuk menyembunyikan password dan token.
     * 
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke Level
     * Relasi ini menghubungkan model User dengan model Level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Relasi ke Pembayaran
     * Relasi ini menghubungkan model User dengan model Pembayaran.
     * Setiap Admin dan Petugas dapat mencatat banyak pembayaran.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}