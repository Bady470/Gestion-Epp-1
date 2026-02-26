<?php

use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\Api\EppImportController;
use App\Http\Controllers\Api\FichaImportController;
use App\Http\Controllers\Api\ProgramaImportController;
use App\Http\Controllers\Api\UserImportController;
use App\Http\Controllers\LiderController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ElementoPPController;

use App\Http\Controllers\NotificacionController;
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

    Route::prefix('admin')->group(function () {
        Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/pedidos/{id}', [AdminPedidoController::class, 'show'])->name('admin.pedidos.show');
        Route::get('/dashboard/admin', [AdminPedidoController::class, 'dashboard'])->name('dashboard.admin');
         Route::get('/productos/area', [AdminPedidoController::class, 'productosArea'])->name('admin.productos.area');

        Route::prefix('notificaciones')->group(function () {
            Route::get('/', [NotificacionController::class, 'index'])->name('notificaciones.index');
            Route::get('/count', [NotificacionController::class, 'count'])->name('count');
            Route::post('/{id}/marcar-leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcar-leida');
            Route::post('/{id}/marcar-no-leida', [NotificacionController::class, 'marcarNoLeida'])->name('notificaciones.marcar-no-leida');
            Route::post('/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar-todas');
            Route::delete('/{id}', [NotificacionController::class, 'destroy'])->name('notificaciones.destroy');
        });
    });

    // Instructor

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
    Route::post('/carrito/agregar-multiple', [CarritoController::class, 'agregarMultiple'])->name('carrito.agregarMultiple');
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


    // rutas de importacion de archivos excel
    Route::post('/users/import', [UserImportController::class, 'import']);
    Route::post('/programas/import', [ProgramaImportController::class, 'import']);
    Route::post('/fichas/import', [FichaImportController::class, 'import']);

    Route::post('/epp/import', [EppImportController::class, 'import']);
    Route::post('/elementos_pp/import', [ElementoPPController::class, 'import'])
        ->name('elementos_pp.import');
});
