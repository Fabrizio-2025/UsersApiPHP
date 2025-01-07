<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Tabla asociada

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'usuario_id',
    ];

    // Relación: Un cliente pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }

    // Relación: Un cliente tiene muchas mascotas
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'cliente_id');
    }
}
