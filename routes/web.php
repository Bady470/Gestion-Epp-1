<?php

use App\Http\Controllers\LiderController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ElementoPPController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\InstructoresController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
// Dashboards por rol
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');

    Route::get('/instructor/dashboard', [InstructoresController::class, 'index'])
        ->name('dashboard.instructor');

// Líder
    Route::get('/dashboard/lider', [LiderController::class, 'index'])
         ->name('dashboard.lider');


    // Route::get('/dashboard/lider', [LiderController::class, 'index'])->name('lider.index');
    Route::post('/lider/enviar/{id}', [LiderController::class, 'enviarPedido'])->name('lider.enviar');
Route::post('/lider/enviar-todos', [LiderController::class, 'enviarTodos'])
    ->name('lider.enviar.todos');


    // crud de usuarios que lo maneja el admin

    Route::resource('usuarios', UserController::class);
    Route::resource('fichas', FichaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('elementos_pp', ElementoPPController::class);
    Route::resource('programas', ProgramaController::class);

    // logica del instructor
    // rutas de pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');


    // rutas del carrito de compras
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])->name('carrito.confirmar');
    // 🔹 Pedidos del líder
    Route::get('/lider/pedidos', [LiderController::class, 'index'])->name('lider.pedidos');
    Route::post('/lider/pedidos/{id}/aprobar', [LiderController::class, 'aprobar'])->name('lider.aprobar');
    Route::post('/lider/pedidos/{id}/rechazar', [LiderController::class, 'rechazar'])->name('lider.rechazar');
    // rutas de solicitudes
    Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/{id}', [SolicitudController::class, 'show'])->name('solicitudes.show');
    Route::post('/solicitudes/{id}/enviar', [SolicitudController::class, 'enviar'])->name('solicitudes.enviar');
});