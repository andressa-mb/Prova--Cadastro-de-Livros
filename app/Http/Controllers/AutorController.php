<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\AutorLink;

class AutorController extends Controller
{
/*     public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'store']);
    } */

    public function index()
    {
        $autores = Autor::with('links')
        ->withCount('livros')
        ->orderBy('nome', 'asc')
        ->paginate(4);

        return view('autores.index', compact('autores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3|max:60',
            'bio' => 'nullable|max:300',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_nome' => 'nullable|array',
            'site_link' => 'nullable|array',
            'site_nome.*' => 'nullable|string|max:20',
            'site_link.*' => 'nullable|max:120'
        ]);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->foto->store('autores_fotos', 'public');
        } else {
            $fotoPath = null;
        }
        
        $autor = Autor::create([
            'nome' => $request->nome,
            'bio' => $request->bio,
            'foto' => $fotoPath
        ]);

        if (!empty($request->site_nome) && !empty($request->site_link)) {
            foreach ($request->site_nome as $key => $site) {
                if (!empty($site) && !empty($request->site_link[$key])) {
                    AutorLink::create([
                        'autor_id' => $autor->id,
                        'site_nome' => $site,
                        'site_link' => $request->site_link[$key]
                    ]);
                }
            }
        }
        
        return redirect('/autores')->with('success', 'Autor cadastrado com sucesso!');
    }

    public function show($id)
    {
        $autor = Autor::with(['livros' => function ($query) {
            $query->orderBy('titulo', 'asc');
        }])->findOrFail($id);

        return view('autores.show', compact('autores'));
    }

    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autores.edit', compact('autores'));
    }

    public function destroy($id){
        $autor = Autor::findOrFail($id);
        $autor->delete();

        return redirect('/autores')->with('success', 'Autor excluído com sucesso!');
    }
}
