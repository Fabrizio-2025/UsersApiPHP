<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $cliente = Cliente::create($validatedData);

        return response()->json([
            'message' => 'Cliente registrado exitosamente.',
            'cliente' => $cliente,
        ], 201);
    }

    public function index()
    {
        $clientes = Cliente::with('mascotas')->get(); // Incluye mascotas relacionadas

        return response()->json($clientes, 200);
    }


}
