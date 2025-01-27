<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:255', // Nombre mínimo de 5 caracteres
            'email' => 'required|email', // Validar formato de email
            'password' => 'required|string|min:8', // Contraseña mínima de 8 caracteres
        ]);

        $existingEmail = Usuarios::where('email', $validatedData['email'])->first();

        if ($existingEmail) {
            return response()->json([
                'message' => 'El correo ya está en uso, Choom.',
            ], 422); // Código HTTP 422: Unprocessable Entity
        }

        $user = Usuarios::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Encriptar contraseña
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente, Choom.',
            'user' => $user,
        ], 201); // Código HTTP 201: Created
    }

    // Login de usuario
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $usuario = Usuarios::where('email', $validatedData['email'])->first();

        if (!$usuario) {
            return redirect()->back()->withErrors(['error' => 'Usuario no encontrado, Choom.']);
        }

        if (!Hash::check($validatedData['password'], $usuario->password)) {
            return redirect()->back()->withErrors(['error' => 'Contraseña incorrecta, Choom.']);
        }

        $token = $usuario->createToken('auth_token')->plainTextToken;

        $clientes = Cliente::with('mascotas')->get();

        return view('clientes', compact('clientes', 'usuario'))->with('message', 'Bienvenido, ' . $usuario->name . ', Choom.');
    }

    // Obtener lista de usuarios
    public function index()
    {
        $usuarios = Usuarios::all();

        return response()->json([
            'usuarios' => $usuarios,
        ], 200);
    }

    // Eliminar usuario
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

    // Actualizar usuario
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
