<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;
class LivroController extends Controller 
{
    public function index(Request $request){
        $query = Livro::query();

        if ($request->filled('pesquisar')) {
            $pesquisar = $request->input('pesquisar');

            $query->where('titulo', 'ILIKE', "%{$pesquisar}%")
                ->orWhere('editora', 'ILIKE', "%{$pesquisar}%")
                ->orWhere('keywords', 'ILIKE', "%{$pesquisar}%")
                ->orWhereHas('categorias', function ($q) use ($pesquisar) {
                    $q->where('nome', 'ILIKE', "%{$pesquisar}%");
                })
                ->orWhereHas('autores', function ($q) use ($pesquisar) {
                    $q->where('nome', 'ILIKE', "%{$pesquisar}%");
                });
        }

        $livros = $query->paginate(12);

        return view('livros.index', compact('livros'));
    }

    public function create(){
        $livros = Livro::all();
        $autores = Autor::all();
        $categorias = Categoria::all();
        return view('livros.cadastro', compact('livros', 'autores', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'capa' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titulo' => 'required|min:3|max:100',
            'editora' => 'required|min:3|max:30',
            'data_publicacao' => 'required|date',
            'keywords' => 'nullable|string|max:100',
            'autor' => 'required|array|min:1',
            'autor.*' => 'exists:autores,id',
            'categoria' => 'required|array|min:1',
            'categoria.*' => 'exists:categorias,id',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'editora.required' => 'A editora é obrigatória.',
            'data_publicacao.required' => 'A data de publicação é obrigatória.',
            'autor.required' => 'Selecione pelo menos um autor.',
            'categoria.required' => 'Selecione pelo menos uma categoria.',
        ]);

        $livro = Livro::create([
            'capa' => $request->capa,
            'titulo' => $request->titulo,
            'editora' => $request->editora,
            'data_publicacao' => $request->data_publicacao,
            'keywords' => $request->keywords,
        ]);

        $livro->autores()->sync($request->autor);
        $livro->categorias()->sync($request->categoria);

        return redirect('/')->with('success', 'Livro cadastrado com sucesso!');
    
    }

    public function edit($id)
    {
        $livros = Livro::findOrFail($id);
        $autores = Autor::all();
        $categorias = Categoria::all();
        return view('livros.edit', compact('livros', 'autores', 'categorias'));

    }

    public function update(Request $request, $id)
    {
        $livro = Livro::findOrFail($id);

        $request->validate([
            'capa' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titulo' => 'required|min:3|max:100',
            'editora' => 'required|min:3|max:30',
            'data_publicacao' => 'required|date',
            'keywords' => 'nullable|string|max:100',
            'autor' => 'required|array|min:1',
            'autor.*' => 'exists:autores,id',
            'categoria' => 'required|array|min:1',
            'categoria.*' => 'exists:categorias,id',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'editora.required' => 'A editora é obrigatória.',
            'data_publicacao.required' => 'A data de publicação é obrigatória.',
            'autor.required' => 'Selecione pelo menos um autor.',
            'categoria.required' => 'Selecione pelo menos uma categoria.',
        ]);

        $livro->update([
            'capa' => $request->capa,
            'titulo' => $request->titulo,
            'editora' => $request->editora,
            'data_publicacao' => $request->data_publicacao,
            'keywords' => $request->keywords,
        ]);

        $livro->autores()->sync($request->autor);
        $livro->categorias()->sync($request->categoria);

        return redirect('/')->with('success', 'Livro atualizado com sucesso!');
   }

    public function destroy($id){
        $livro = Livro::findOrFail($id);
        $livro->autores()->detach();
        $livro->categorias()->detach();
        $livro->delete();

        return redirect('/')->with('success', 'Livro excluído com sucesso!');
    }

    public function show($id){
        $livro = Livro::with('autores', 'categorias', 'favoritos')->with(['comentarios' => function($query) {
            $query->where('ativo', true);
        }])->findOrFail($id);

        $favorito = Favorito::where('livro_id', $livro->id)
        ->where('leitor_id', Auth::id())
        ->first();
        return view('livros.show', compact('livro', 'favorito'));
    }
}