<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'productor_id',
        'tipo_maiz_id',
        'sesion_id',
        'fecha_recepcion',
        'cantidad_kg',
        'observaciones',
        'estado',
    ];

    public function productor(): BelongsTo
    {
        return $this->belongsTo(Productor::class);
    }

    public function tipoMaiz(): BelongsTo
    {
        return $this->belongsTo(TipoMaiz::class, 'tipo_maiz_id');
    }

    public function clasificaciones(): HasMany
    {
        return $this->hasMany(Clasificacion::class);
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(Alerta::class);
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function ultimaClasificacion(): HasOne
    {
        return $this->hasOne(Clasificacion::class)->latestOfMany();
    }
}
