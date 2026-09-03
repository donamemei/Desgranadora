<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    // Lista todos los usuarios
    public function index(): View
    {
        $usuarios = User::orderBy('name')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    // Formulario de creación
    public function crear(): View
    {
        return view('usuarios.form', ['usuario' => null]);
    }

    // Guarda nuevo usuario
    public function guardar(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'rol'      => 'required|in:administrador,supervisor,operador',
        ], [
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'rol'      => $data['rol'],
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // Formulario de edición
    public function editar(int $id): View
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.form', compact('usuario'));
    }

    // Actualiza usuario existente
    public function update(Request $request, int $id)
    {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:8|confirmed',
            'rol'      => 'required|in:administrador,supervisor,operador',
        ], [
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario->name  = $data['name'];
        $usuario->email = $data['email'];
        $usuario->rol   = $data['rol'];

        // Solo cambia la contraseña si se envió una nueva
        if (! empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // Elimina usuario (no puede eliminarse a sí mismo)
    public function destroy(Request $request, int $id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado.');
    }
}
