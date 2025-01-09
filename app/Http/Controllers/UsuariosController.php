<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:255', // El name requiere mínimo 5 caracteres
            'email' => 'required|email', // Validar formato de email
            'password' => 'required|string|min:8', // Contraseña mínima de 8 caracteres
        ]);

        // Verificar si el email ya está registrado
        $existingEmail = Usuarios::where('email', $validatedData['email'])->first();

        if ($existingEmail) {
            return response()->json([
                'message' => 'El correo ya está en uso, Choom.',
            ], 422); // Código HTTP 422: Unprocessable Entity
        }

        // Crear el nuevo usuario
        $user = Usuarios::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Encriptar la contraseña
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente, Choom.',
            'user' => $user,
        ], 201); // Código HTTP 201: Created
    }

    public function index()
    {
        $usuarios = Usuarios::all();

        return response()->json([
            'usuarios' => $usuarios,
        ], 200);
    }

    public function delete($id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado, Choom.',
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente, Choom.',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|min:5|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado, Choom.',
            ], 404);
        }

        $usuario->update($validatedData);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente, Choom.',
            'user' => $usuario,
        ], 200);
    }
}
