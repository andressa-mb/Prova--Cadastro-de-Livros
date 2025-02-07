<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Hash;

//ROTAS DE LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'create']);

Route::post('/register_store', [RegisterController::class, 'store'])->name('register.store');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

//ROTA DE TELA PRINCIPAL TODOS ACESSAM
Route::get('/', [LivroController::class, 'index'])->name('livros.index');
Route::get('/livros/{id}/show', [LivroController::class, 'show'])->name('livros.show');

//LEITOR VER O QUE PRECISA CONFIGURAR
Route::middleware(['auth'])->group(function () {
    Route::post('/livro/{livro_id}/comentario', [ComentarioController::class, 'store'])->name('comentario.store');
    Route::delete('/comentario/{comentario_id}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');
    Route::post('/livro/{livro_id}/favorito', [FavoritoController::class, 'store'])->name('favorito.store');
});

//ÁREA ADMIN, CONFIGURAR TUDO QUE ELE PODE AQUI 
Route::middleware(['auth', 'acesso'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/lista', [AdminController::class, 'listaAdmins'])->name('admin.lista');
    Route::get('/admin/cadastro', [AdminController::class, 'create'])->name('admin.cadastro');
    Route::post('/admin/cadastronovo', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');

    //COMENTÁRIOS
    Route::put('/comentario/{comentario_id}/desativar', [ComentarioController::class, 'desativar'])->name('comentario.desativar');

    //AUTORES
    Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
    Route::get('/autores_create', [AutorController::class, 'create'])->name('autores.cadastro');
    Route::post('/autores_cadastro', [AutorController::class, 'store'])->name('autores.store');
    Route::get('/autores/{id}/show', [AutorController::class, 'show'])->name('autores.show');
    Route::get('/autores/{id}/edit', [AutorController::class, 'edit'])->name('autores.edit');
    Route::put('/autores/{id}', [AutorController::class, 'update'])->name('autores.update');
    Route::delete('/autores/{id}/delete', [AutorController::class, 'destroy'])->name('autores.destroy');
    
    //LIVROS
    Route::get('/livros_create', [LivroController::class, 'create'])->name('livros.cadastro');
    Route::post('/livros_cadastro', [LivroController::class, 'store'])->name('livros.store');
    Route::get('/livros/{id}/edit', [LivroController::class, 'edit'])->name('livros.edit');
    Route::put('/livros/{id}', [LivroController::class, 'update'])->name('livros.update');
    Route::delete('/livros/{id}/delete', [LivroController::class, 'destroy'])->name('livros.destroy');
    
    //CATEGORIAS
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias_create', [CategoriaController::class, 'create'])->name('categorias.cadastro');
    Route::post('/categorias_cadastro', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{id}/show', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::get('/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::get('/categorias/{id}/showId', [CategoriaController::class, 'showDelete'])->name('categorias.showDelete');
    Route::delete('/categorias/{id}/delete', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});

Auth::routes();
