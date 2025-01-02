<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
        ]);


        $user = Usuarios::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);


        return response()->json([
            'message' => 'Usuario registrado exitosamente!',
            'user' => $user,
        ], 201);
    }
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = Usuarios::all();

        // Respuesta en formato JSON
        return response()->json([
            'usuarios' => $usuarios,
        ], 200);
    }

    public function delete($id)
    {
        // Buscar el usuario por ID
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        // Eliminar el usuario
        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        // Buscar el usuario por ID
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        // Actualizar los datos del usuario
        $usuario->update($validatedData);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'user' => $usuario,
        ], 200);
    }


}

