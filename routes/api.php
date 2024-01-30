<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello World!',
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    /**CATEGORIES */

    Route::resource('categories', CategoriesController::class);

    // Ruta para obtener transacciones
    Route::get('/transactions', [TransactionsController::class, 'get_transactions']);

    // Ruta para registrar una transacción
    Route::post('/transactions', [TransactionsController::class, 'register_transaction']);
});
