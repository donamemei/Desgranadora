<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ─── Helpers de rol ───────────────────────────────────────────────

    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    public function esSupervisor(): bool
    {
        return $this->rol === 'supervisor';
    }

    public function esOperador(): bool
    {
        return $this->rol === 'operador';
    }

    // Puede ver reportes (admin y supervisor)
    public function puedeVerReportes(): bool
    {
        return in_array($this->rol, ['administrador', 'supervisor']);
    }

    // Puede gestionar usuarios (solo admin)
    public function puedeGestionarUsuarios(): bool
    {
        return $this->rol === 'administrador';
    }

    // Etiqueta de color para el badge en la UI
    public function badgeRol(): string
    {
        return match ($this->rol) {
            'administrador' => 'bg-purple',
            'supervisor'    => 'bg-primary',
            'operador'      => 'bg-success',
            default         => 'bg-secondary',
        };
    }
}
