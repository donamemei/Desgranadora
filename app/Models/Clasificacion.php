<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clasificacion extends Model
{
    protected $table = 'clasificaciones';

    protected $fillable = [
        'lote_id',
        'categoria',
        'porcentaje_primera',
        'porcentaje_segunda',
        'porcentaje_desechos',
        'observaciones',
        'usuario_id',
    ];

    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
