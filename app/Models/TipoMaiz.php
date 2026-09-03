<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMaiz extends Model
{
    protected $table = 'tipos_maiz';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
    ];

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }
}
