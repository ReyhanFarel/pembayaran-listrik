<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $nama_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level whereNamaLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Level whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * Model Level
 *
 * Model ini merepresentasikan tabel 'level' yang menyimpan data level pengguna.
 * Relasi:
 * - User: Setiap level dapat dimiliki oleh banyak pengguna.
 */
class Level extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Diperlukan jika nama tabel tidak sesuai dengan konvensi Laravel.
     *
     * @var string
     */
    protected $table = 'level'; // Diperlukan karena nama tabel singular

    /**
     * Atribut yang dapat diisi secara massal.
     * Ini adalah atribut yang dapat diisi melalui metode seperti create() atau update().
     * Pastikan hanya atribut yang aman untuk diisi yang dimasukkan di sini.
     * @var array
     */
    protected $fillable = ['nama_level'];

    /**
     * Relasi ke Model User
     * Setiap level dapat dimiliki oleh banyak pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // Relasi ke Model User
    public function users(): HasMany
    {
        return $this->hasMany(User::class); // foreign key 'level_id' di tabel 'user'
    }
}