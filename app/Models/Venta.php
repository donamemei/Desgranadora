<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'lote_id',
        'fecha_venta',
        'comprador',
        'cantidad_kg',
        'precio_kg',
        'total',
        'metodo_pago',
        'observaciones',
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'cantidad_kg' => 'decimal:2',
        'precio_kg' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }
}
