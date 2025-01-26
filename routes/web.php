<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta para probar una vista adicional
Route::get('/hola', function () {
    return view('hola'); // Una vista llamada "hola.blade.php"
})->name('hola');

// Rutas de autenticación y usuarios
Route::prefix('usuarios')->group(function () {
    Route::post('/register', [UsuariosController::class, 'register'])->name('usuarios.register');
    Route::post('/login', [UsuariosController::class, 'login'])->name('usuarios.login'); // Cambio a usuarios.login para consistencia
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::put('/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/{id}', [UsuariosController::class, 'delete'])->name('usuarios.delete');
});

// Rutas para clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
});

// Rutas para mascotas
Route::prefix('mascotas')->group(function () {
    Route::get('/', [MascotaController::class, 'index'])->name('mascotas.index');
    Route::post('/', [MascotaController::class, 'store'])->name('mascotas.store');
    Route::put('/{id}', [MascotaController::class, 'update'])->name('mascotas.update');
    Route::delete('/{id}', [MascotaController::class, 'delete'])->name('mascotas.delete');
});

// Rutas para citas
Route::prefix('citas')->group(function () {
    Route::get('/', [CitaController::class, 'index'])->name('citas.index');
    Route::post('/', [CitaController::class, 'store'])->name('citas.store');
    Route::put('/{id}', [CitaController::class, 'update'])->name('citas.update');
    Route::delete('/{id}', [CitaController::class, 'delete'])->name('citas.delete');
});

// Ruta para la vista del login
Route::view('/login', 'login')->name('login.view'); // Nombre consistente con el resto
