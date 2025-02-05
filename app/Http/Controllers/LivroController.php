<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Autor;

class LivroController extends Controller 
{
    public function index(){
        $livros = Livro::with('autores', 'categorias')->paginate(10);

        return view('livros.index', compact ('livros'));
    }

    public function create(){
        $autores = Autor::all();
        
        

        return view('livros.cadastro', compact('autores'));
    }

    public function store(){
        $livros = Livro::with('autores', 'categorias');

        return redirect('/livros')->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $livros = Livro::findOrFail($id);
        return view('livros.edit', compact('livros'));

    }

    public function update(Request $request, $id){
        return redirect('/livros')->with('success', "Livro atualizado.");
    }

    public function destroy($id){
        $livro = Livro::findOrFail($id);
        $livro->delete();
        return redirect('/livros')->with('success', 'Livro excluído com sucesso');
    }

    public function show($id){
        $livro = Livro::with('autores', 'categorias')->findOrFail($id);

        return view('livros.show', compact('livro'));
    }
}