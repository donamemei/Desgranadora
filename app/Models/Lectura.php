<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Lectura extends Model
{
    /**
     * Campos que se pueden asignar masivamente (desde el JSON del Arduino).
     */
    protected $fillable = [
        'rpm',
        'kg_procesados',
        'kg_hora',
        'temperatura',
        'estado_motor',
        'sesion_id',
    ];

    /**
     * Tipos de cada campo para que Laravel los convierta automáticamente.
     */
    protected $casts = [
        'rpm'           => 'float',
        'kg_procesados' => 'float',
        'kg_hora'       => 'float',
        'temperatura'   => 'float',
        'created_at'    => 'datetime',
    ];

    // ─── Scopes útiles para las consultas ──────────────────────────────────

    /**
     * Filtra por sesión: Lectura::deSesion('SES-20241015-001')->get()
     */ 
    public function scopeDeSesion(Builder $query, string $sesionId): Builder
    {
        return $query->where('sesion_id', $sesionId);
    }

    /**
     * Solo las lecturas con motor encendido.
     */
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('estado_motor', 'ON');
    }

    // ─── Métodos de utilidad ────────────────────────────────────────────────

    /**
     * Resumen estadístico de una sesión completa.
     * Usado en los reportes PDF y Excel.
     */
    public static function resumenSesion(string $sesionId): array
    {
        $lecturas = static::deSesion($sesionId)->get();

        if ($lecturas->isEmpty()) {
            return [];
        }

        return [
            'sesion_id'        => $sesionId,
            'total_lecturas'   => $lecturas->count(),
            'kg_total'         => round($lecturas->max('kg_procesados'), 2),
            'rpm_promedio'     => round($lecturas->avg('rpm'), 1),
            'rpm_max'          => round($lecturas->max('rpm'), 1),
            'kg_hora_promedio' => round($lecturas->avg('kg_hora'), 2),
            'temp_max'         => round($lecturas->max('temperatura'), 1),
            'inicio'           => $lecturas->first()->created_at->format('d/m/Y H:i'),
            'fin'              => $lecturas->last()->created_at->format('d/m/Y H:i'),
            'duracion_min'     => $lecturas->first()->created_at
                                    ->diffInMinutes($lecturas->last()->created_at),
        ];
    }
}
