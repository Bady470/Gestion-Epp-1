<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ElementoPPController;

use App\Http\Controllers\AuthController;
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

    Route::get('/dashboard/lider', function () {
        return view('dashboard.lider');
    })->name('dashboard.lider');


    // crud de usuarios que lo maneja el admin

    Route::resource('usuarios', UserController::class);
    Route::resource('fichas', FichaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('elementos_pp', ElementoPPController::class);
    Route::resource('programas', ProgramaController::class);

    // logica del instructor


});
