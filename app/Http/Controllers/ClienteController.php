<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20', // El phone es obligatorio
            'address' => 'nullable|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        // Verificar si ya existe un cliente con el mismo nombre y teléfono para el usuario
        $existingCliente = Cliente::where('name', $validatedData['name'])
            ->where('phone', $validatedData['phone'])
            ->where('usuario_id', $validatedData['usuario_id'])
            ->first();

        if ($existingCliente) {
            return response()->json([
                'message' => 'El cliente ya está registrado para este usuario, Choom.',
            ], 422); // Código HTTP 422: Unprocessable Entity
        }

        // Crear el nuevo cliente
        $cliente = Cliente::create($validatedData);

        return response()->json([
            'message' => 'Cliente registrado exitosamente, Choom.',
            'cliente' => $cliente,
        ], 201); // Código HTTP 201: Created
    }

    public function index()
    {
        // Obtener todos los clientes con sus mascotas relacionadas
        $clientes = Cliente::with('mascotas')->get();

        return response()->json($clientes, 200);
    }
}
