<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\Livro;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('livros')
        ->withCount('livros')
        ->orderBy('nome')
        ->get();

        return view('categorias.index', compact ('categorias'));
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        $livros = $categoria->livros()->orderBy('titulo', 'asc')->paginate(5);

        return view('categorias.show', compact('categoria', 'livros'));
    }

    
    public function create()
    {
        $livros = Livro::orderBy('titulo')->get(); 
        
        return view('categorias.cadastro', compact('livros'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:categorias,nome|min:3|max:30',
            'descricao' => 'nullable|max:100',
            'livros' => 'array'
        ]);
        
        $categoriaExistente = Categoria::whereRaw('LOWER(nome) = ?', [strtolower($request->nome)])->first();
        
        if ($categoriaExistente) {
            return redirect()->back()->withErrors(['nome' => 'Já existe uma categoria com este nome.'])->withInput();
        }
        
        $categoria = Categoria::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);        
        
        if (!empty($request->livros)) {
            $categoria->livros()->attach(array_filter($request->livros));
        }
        
        if ($request->input('modal') === 'true') {
            return redirect()->back()->with('success', 'Categoria criada com sucesso.', $categoria);
        }
        
        return redirect('/categorias')->with('success', 'Categoria cadastrada com sucesso!');
        
    }
    
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        $livros = Livro::orderBy('titulo')->get();
        return view('categorias.edit', compact('categoria', 'livros'));
    }
    
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        
        $request->validate([
            'nome' => ['required',
            'min:3',
            'max:30',
            Rule::unique('categorias', 'nome')->ignore($categoria->id)],
            'descricao' => 'nullable|max:100',
            'livros' => 'array'
        ]);  

        $categoriaExistente = Categoria::whereRaw('LOWER(nome) = ?', [strtolower($request->nome)])
        ->where('id', '!=', $categoria->id)
        ->first();

        if ($categoriaExistente) {
            return redirect()->back()->withErrors(['nome' => 'Já existe uma categoria com este nome.'])->withInput();
        }

        
        $categoria->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);
        
        if (isset($request->livros)) {
            $categoria->livros()->sync($request->livros);
        } else {
            $categoria->livros()->sync([]);
        }
        
        return redirect('/categorias')->with('success', 'Categoria atualizada com sucesso.');
        
    }
    
    public function showDelete($id){
        $categoria = Categoria::findOrFail($id);

        $livros = $categoria->livros()->orderBy('titulo', 'asc')->paginate(5);

        return view('categorias.destroy', compact('categoria', 'livros'));
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->livros->isEmpty()) {
            $categoria->delete();
            return redirect('/categorias')->with('success', 'Categoria excluída com sucesso.');
        }

        $livrosSomenteNestaCategoria = $categoria->livros->filter(function ($livro) {
            return $livro->categorias()->count() == 1;
        });

        if ($livrosSomenteNestaCategoria->isNotEmpty()) {
            return redirect()->back()->withErrors(['msg' => 'Não é possível excluir esta categoria porque há livros que pertencem apenas a ela.']);
        }

        DB::table('livro_categoria')->where('categoria_id', $id)->delete();


        $categoria->delete();
        return redirect('/categorias')->with('success', 'Categoria excluída com sucesso.');
    }
}
