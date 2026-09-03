<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $fillable = [
        'lote_id',
        'tipo_alerta',
        'mensaje',
        'nivel',
        'leida',
    ];

    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }
}
