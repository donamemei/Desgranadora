<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Productor extends Model
{
    protected $table = 'productores';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'direccion',
        'municipio',
    ];

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }

    public function ventas(): HasMany
    {
        return $this->hasManyThrough(Venta::class, Lote::class);
    }
}
