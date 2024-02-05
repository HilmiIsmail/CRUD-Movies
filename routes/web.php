<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EtiquetaController;
use App\Livewire\ShowPeliculas;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //rutas protegidas
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('etiquetas', EtiquetaController::class)->except('show');

    Route::get('peliculas', ShowPeliculas::class)->name('peliculas.show');
});
