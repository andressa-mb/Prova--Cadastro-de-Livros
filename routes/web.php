<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AutorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::post('/autores_cadastro', [AutorController::class, 'store'])->name('autores.store');
Route::get('/autores/show/id', [AutorController::class, 'show'])->name('autores.show');
Route::get('/autores/{id}/edit', [AutorController::class, 'edit'])->name('autores.edit');
Route::put('/autores/{id}', [AutorController::class, 'update'])->name('autores.update');
Route::delete('/autores/{id}/delete', [AutorController::class, 'destroy'])->name('autores.destroy');

Auth::routes();
