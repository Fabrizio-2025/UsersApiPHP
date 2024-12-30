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
}

