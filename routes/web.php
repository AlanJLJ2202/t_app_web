<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccesoController;

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


Route::post('/login',[AccesoController::class, 'login'])->name('login');
Route::get('/admin',[AccesoController::class, 'view_index'])->name('index');


Route::get('/', function () {
    return view('login');
});


Route::get('/portafolio', function () {
    return view('portafolio');
});


