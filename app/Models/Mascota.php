<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas'; // Nombre de la tabla

    protected $fillable = [
        'name',
        'especie',
        'raza',
        'edad',
        'cliente_id',
    ];

    // Relación: Una mascota pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
