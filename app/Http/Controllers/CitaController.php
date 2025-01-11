<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    // Registrar una nueva cita
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'mascota_id' => 'required|exists:mascotas,id',
                'tipo_cita' => 'required|string|max:255',
                'fecha_hora' => 'nullable|date|after:now', // Solo futuro si se proporciona
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|string|in:pendiente,completada,cancelada',
            ]);

            // Si no se proporciona `fecha_hora`, se establece la hora actual
            if (!isset($validatedData['fecha_hora'])) {
                $validatedData['fecha_hora'] = now();
            }

            // Crear la cita
            $cita = Cita::create($validatedData);

            return response()->json([
                'message' => 'Cita registrada exitosamente.',
                'cita' => $cita,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la cita.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener todas las citas
    public function index()
    {
        try {
            $citas = Cita::with(['cliente', 'mascota'])
                ->orderBy('fecha_hora', 'asc')
                ->get(); // Incluye datos de cliente y mascota

            return response()->json($citas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las citas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar una cita
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'mascota_id' => 'sometimes|exists:mascotas,id',
                'cliente_id' => 'sometimes|exists:clientes,id',
                'tipo_cita' => 'sometimes|string|max:255',
                'fecha_hora' => 'nullable|date|after:now', // Solo futuro si se proporciona
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|string|in:pendiente,completada,cancelada',
            ]);

            $cita = Cita::find($id);

            if (!$cita) {
                return response()->json([
                    'message' => 'Cita no encontrada.',
                ], 404);
            }

            // Si no se proporciona `fecha_hora` y se está actualizando, mantener la actual
            if (!isset($validatedData['fecha_hora']) && $cita->fecha_hora) {
                $validatedData['fecha_hora'] = $cita->fecha_hora;
            }

            $cita->update($validatedData);

            return response()->json([
                'message' => 'Cita actualizada exitosamente.',
                'cita' => $cita,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la cita.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar una cita
    public function delete($id)
    {
        try {
            $cita = Cita::find($id);

            if (!$cita) {
                return response()->json([
                    'message' => 'Cita no encontrada.',
                ], 404);
            }

            $cita->delete();

            return response()->json([
                'message' => 'Cita eliminada exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la cita.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
