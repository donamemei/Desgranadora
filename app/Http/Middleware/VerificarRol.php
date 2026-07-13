<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Uso en rutas:
     *   ->middleware('rol:administrador')
     *   ->middleware('rol:administrador,supervisor')
     *
     * Si el usuario no tiene el rol requerido → 403 Forbidden.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Debe estar autenticado
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        // Verificar si el rol del usuario está en los roles permitidos
        if (! in_array($usuario->rol, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
