<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/autores_create', [AutorController::class, 'create'])->name('autores.cadastro');
Route::post('/autores_cadastro', [AutorController::class, 'store'])->name('autores.store');
Route::get('/autores/{id}/show', [AutorController::class, 'show'])->name('autores.show');
Route::get('/autores/{id}/edit', [AutorController::class, 'edit'])->name('autores.edit');
Route::put('/autores/{id}', [AutorController::class, 'update'])->name('autores.update');
Route::delete('/autores/{id}/delete', [AutorController::class, 'destroy'])->name('autores.destroy');

Route::get('/livros', [LivroController::class, 'index'])->name('livros.index');
Route::get('/livros_create', [LivroController::class, 'create'])->name('livros.cadastro');
Route::post('livros_cadastro', [LivroController::class, 'store'])->name('livros.store');
Route::get('/livros/{id}/show', [LivroController::class, 'show'])->name('livros.show');
Route::get('/livros/{id}/edit', [LivroController::class, 'edit'])->name('livros.edit');
Route::put('/livros/{id}', [LivroController::class, 'update'])->name('livros.update');
Route::delete('/livros/{id}/delete', [LivroController::class, 'destroy'])->name('livros.destroy');

Auth::routes();
