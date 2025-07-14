<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $table = 'level'; // Diperlukan karena nama tabel singular

    protected $fillable = ['nama_level'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class); // foreign key 'level_id' di tabel 'user'
    }
}