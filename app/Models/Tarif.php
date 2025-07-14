<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    use HasFactory;

 protected $table = 'tarifs';

    protected $fillable = ['daya', 'tarif_perkwh'];

    protected $casts = ['tarif_perkwh' => 'decimal:2'];

    public function pelanggans(): HasMany
    {
        return $this->hasMany(Pelanggan::class); // foreign key 'tarif_id' di tabel 'pelanggan'
    }
}