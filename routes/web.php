<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ListasComprasController;

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

Route::match(['GET','POST'],'/', [AccesoController::class, 'login'])->name('login');
//logout
Route::get('/logout', [AccesoController::class, 'logout'])->name('logout');

Route::get('/admin',[AccesoController::class, 'view_index'])->name('index');

Route::get('/portafolio', function () {
    return view('portafolio');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [TransactionsController::class, 'view_dashboard'])->name('dashboard');
    Route::get('/api/transactions', [TransactionsController::class, 'get_transactions']);
    Route::post('/api/transactions', [TransactionsController::class, 'register_transaction']);

    Route::get('/listas_compras', [ListasComprasController::class, 'view_listas'])->name('listas_compras');
    Route::get('/api/listas_compras', [ListasComprasController::class, 'get_listas']);
    Route::get('/api/categorias', [ListasComprasController::class, 'get_categorias']);
    Route::get('/api/productos', [ListasComprasController::class, 'get_productos']);
    Route::post('/api/listas_compras', [ListasComprasController::class, 'register_lista']);
    Route::post('/api/productos', [ListasComprasController::class, 'register_producto']);
    Route::put('/api/productos/{id}', [ListasComprasController::class, 'update_producto']);
    Route::post('/api/productos_categoria', [ListasComprasController::class, 'register_producto_categoria']);
});

