<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $mascota = Mascota::create($validatedData);

        return response()->json([
            'message' => 'Mascota registrada exitosamente.',
            'mascota' => $mascota,
        ], 201);
    }

    public function index()
    {
        $mascotas = Mascota::with('cliente')->get(); // Incluye datos del cliente relacionado

        return response()->json($mascotas, 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'especie' => 'sometimes|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'cliente_id' => 'sometimes|exists:clientes,id',
        ]);

        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json([
                'message' => 'Mascota no encontrada.',
            ], 404);
        }

        $mascota->update($validatedData);

        return response()->json([
            'message' => 'Mascota actualizada exitosamente.',
            'mascota' => $mascota,
        ], 200);
    }

    public function delete($id)
    {
        $mascota = Mascota::find($id);

        if (!$mascota) {
            return response()->json([
                'message' => 'Mascota no encontrada.',
            ], 404);
        }

        $mascota->delete();

        return response()->json([
            'message' => 'Mascota eliminada exitosamente.',
        ], 200);
    }



}
