<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InvitadoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
});

//Dentro deben de ir las rutas de las peticiones del backend para movimientos internos que necesiten una autenticación de usuario
//fuera del group se pueden poner rutas que no ocupen una autenticación de usuario, publicas les podriamos decir. 
Route::group(['middleware' => 'auth:sanctum'], function($router) {
    
    //Ruta para obtener los tipos de usuario
    Route::get('/tipo-usuarios', [TipoUsuarioController::class, 'getTipoUsuarios']);

    //Rutas para el catalogo de usuarios
    Route::get('/usuarios', [UserController::class, 'getUsuarios']);
    Route::post('/usuarios/crear-usuario', [UserController::class, 'guardarUsuario']);
    Route::post('/usuarios/actualizar-usuario', [UserController::class, 'actualizarUsuario']);
    Route::post('/usuarios/eliminar-usuario', [UserController::class, 'eliminarUsuario']);


    //Eventos
    Route::get('/eventos', [EventoController::class, 'getEventos']);
    Route::post('/eventos/crear-evento', [EventoController::class, 'guardarEvento']);
    Route::post('/eventos/eliminar-evento', [EventoController::class, 'eliminarEvento']);
    Route::post('/eventos/actualizar-evento', [EventoController::class, 'actualizarEvento']);

    //Rutas para el catalogo de invitados
    Route::post('/invitados', [InvitadoController::class, 'getInvitados']);
    Route::post('/invitados/crear-invitado', [InvitadoController::class, 'guardarInvitado']);
    Route::post('/invitados/actualizar-invitado', [InvitadoController::class, 'actualizarInvitado']);
    Route::post('/invitados/eliminar-invitado', [InvitadoController::class, 'eliminarInvitado']);
    //Ruta para generar el codigo QR
    Route::post('/invitados/generar-codigo-qr', [InvitadoController::class, 'generarCodigoQR']);
    Route::post('/invitados/buscar-folio', [InvitadoController::class, 'buscarFolio']);
    Route::post('/invitados/buscar-invitados', [InvitadoController::class, 'buscarInvitado']);
    Route::post('/invitados/enviar-correo', [InvitadoController::class, 'enviarCorreo']);

    Route::post('/invitados/import', [InvitadoController::class, 'importInvitados']);



});
