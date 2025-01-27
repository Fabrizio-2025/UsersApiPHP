<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

// -----------------------------------------
// RUTAS PRINCIPALES
// -----------------------------------------

// Ruta principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta adicional para prueba
Route::get('/hola', function () {
    return view('hola'); // Vista "hola.blade.php"
})->name('hola');

// Ruta para la vista de inicio de sesión
Route::view('/login', 'auth.login')->name('login.view');

// -----------------------------------------
// RUTAS DE AUTENTICACIÓN Y USUARIOS
// -----------------------------------------

Route::post('/usuarios/register', [UsuariosController::class, 'register'])->name('usuarios.register');
Route::post('/usuarios/login', [UsuariosController::class, 'login'])->name('usuarios.login');
Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuariosController::class, 'delete'])->name('usuarios.delete');

// -----------------------------------------
// RUTAS PARA CLIENTES
// -----------------------------------------

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// Ruta para la vista de "mis clientes"
// Ruta para mostrar la vista de "mis clientes" sin autenticación
Route::get('/clientes/mis-clientes', [ClienteController::class, 'showClientesByUsuario'])->name('clientes.mis-clientes');




// -----------------------------------------
// RUTAS PARA MASCOTAS
// -----------------------------------------

Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
Route::post('/mascotas', [MascotaController::class, 'store'])->name('mascotas.store');
Route::put('/mascotas/{id}', [MascotaController::class, 'update'])->name('mascotas.update');
Route::delete('/mascotas/{id}', [MascotaController::class, 'delete'])->name('mascotas.delete');

// -----------------------------------------
// RUTAS PARA CITAS
// -----------------------------------------

Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
Route::delete('/citas/{id}', [CitaController::class, 'delete'])->name('citas.delete');
