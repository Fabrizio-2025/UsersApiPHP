<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'cliente_id',
        'mascota_id',
        'tipo_cita',
        'fecha_hora',
        'descripcion',
        'estado',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con Mascota
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}
