<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PublicarController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CiudadeController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ItemcarritoController;
use App\Http\Controllers\DatosPagoController;
use App\Http\Controllers\VentaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

//inicio route
Route::controller(InicioController::class)
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('inicio', 'index')->name('inicio.index');
    });

//categorías route
Route::controller(CategoriaController::class)
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('categorias', 'index')->name('categorias.index');
        Route::put('categorias/{categoria}', 'update')->name('categorias.update');
        Route::post('categorias', 'store')->name('categorias.store');
        Route::delete('categorias/{categoria}', 'destroy')->name('categorias.destroy');
    });

//proveedores
Route::controller(ProveedoresController::class)
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('proveedores', 'index')->name('proveedores.index');
        Route::get('proveedores/create', 'create')->name('proveedores.create');
        Route::get('proveedores/{proveedor}/edit', 'edit')->name('proveedores.edit');
        Route::get('proveedores/{proveedor}', 'destroy')->name('proveedores.destroy');
    });


//proveedores
/* Route::resource('proveedores', ProveedoresController::class)
    ->middleware(['auth:sanctum', 'verified']); */


//Productos
Route::resource('productos', ProductosController::class)
    ->middleware(['auth:sanctum', 'verified']);
//Ventas

Route::resource('ventas', VentaController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('message', MessageController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('publicar', PublicarController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('itemcarritos', ItemcarritoController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('carritos', CarritoController::class)
    ->middleware(['auth:sanctum', 'verified']);


Route::resource('datospago', DatosPagoController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('envios', EnvioController::class)
    ->middleware(['auth:sanctum', 'verified']);


Route::post('carritos/addItemToCart', [CarritoController::class, 'addItemToCart'])->name('carritos.addItemToCart');
