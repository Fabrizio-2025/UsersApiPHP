<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hola', function () {
    return view('hola');
});

Route::post('/register',[UsuariosController::class,'register']);

Route::get('/usuarios',[UsuariosController::class,'index']);

Route::delete('/usuarios/{id}',[UsuariosController::class,'delete']);

Route::put('/usuarios/{id}',[UsuariosController::class,'update']);

