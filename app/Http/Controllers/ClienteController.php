<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Crear un nuevo cliente
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20', // El teléfono es obligatorio
            'address' => 'nullable|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $existingCliente = Cliente::where('name', $validatedData['name'])
            ->where('phone', $validatedData['phone'])
            ->where('usuario_id', $validatedData['usuario_id'])
            ->first();

        if ($existingCliente) {
            return response()->json([
                'message' => 'El cliente ya está registrado para este usuario, Choom.',
            ], 422); // Código HTTP 422: Unprocessable Entity
        }

        $cliente = Cliente::create($validatedData);

        return response()->json([
            'message' => 'Cliente registrado exitosamente, Choom.',
            'cliente' => $cliente,
        ], 201); // Código HTTP 201: Created
    }

    // Obtener todos los clientes con sus mascotas
    public function index()
    {
        $clientes = Cliente::with('mascotas')->get();

        return response()->json([
            'message' => 'Lista de clientes obtenida exitosamente, Choom.',
            'clientes' => $clientes,
        ], 200);
    }

    // Mostrar clientes ordenados por nombre
    public function showClientesByUsuario()
    {
        $clientes = Cliente::orderBy('name', 'asc')->get(); // Ordenar por nombre

        return view('clientes', compact('clientes'))
            ->with('message', 'Aquí está la lista de clientes, Choom.');
    }
}
