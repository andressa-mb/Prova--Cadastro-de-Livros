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
        ->paginate(10);

        return view('autores.index', compact('autores'));
    }

    public function create(){
        $autores = Autor::with('links');

        return view('autores.cadastro', compact($autores));
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

        if ($request->input('modal') === 'true') {
            return redirect()->back()->with('success', 'Autor criado com sucesso.', $autor);
        }
        
        return redirect('/autores')->with('success', 'Autor cadastrado com sucesso!');
    }

    public function show($id)
    {
        $autor = Autor::with(['livros' => function ($query) {
            $query->orderBy('titulo', 'asc');
        }, 
        'livros.categorias'
        ])->findOrFail($id);

        return view('autores.show', compact('autor'));
    }

    public function edit($id)
    {
        $autor = Autor::findOrFail($id); 
        $autorLinks = AutorLink::where('autor_id', $id)->get();
        return view('autores.edit', compact('autor', 'autorLinks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|min:3|max:60',
            'bio' => 'nullable|max:300',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_nome' => 'nullable|array',
            'site_link' => 'nullable|array',
            'site_nome.*' => 'nullable|string|max:20',
            'site_link.*' => 'nullable|max:120'
        ]);
        
        $autor = Autor::findOrFail($id);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->foto->store('autores_fotos', 'public');
        } else {
            $fotoPath = $autor->foto;
        }

        $autor->update([
            'nome' => $request->nome,
            'bio' => $request->bio,
            'foto' => $fotoPath
        ]);

        
        $existeLinkAutor = AutorLink::where('autor_id', $id)->exists();
        if($existeLinkAutor){
            if ($request->has('removidos') && !empty($request->removidos)) {
                $idsRemovidos = explode(",", $request->removidos);
                if (count($idsRemovidos) > 0) {
                    AutorLink::whereIn('id', $idsRemovidos)->delete();
                }
            }

            $siteNames = $request->input('site_nome');
            $siteLinks = $request->input('site_link');

            if(is_array($siteNames)){
                foreach($siteNames as $key=>$siteNome){
                    $siteLink = $siteLinks[$key] ?? null;
                    $siteId = $request->site_id[$key] ?? null;
                    if(!empty($siteNome) && !empty($siteLink)){
                        if(!empty($siteId)){
                            AutorLink::where('id', $siteId)->update([
                                'site_nome' => $siteNome,
                                'site_link' => $siteLink
                            ]);
                        } 
                        if (empty($siteId)){
                            AutorLink::create([
                                'autor_id' => $autor->id,
                                'site_nome' => $siteNome,
                                'site_link' => $siteLink
                            ]);
                        }
                    }
                }
            }    
        }

        return redirect('/autores')->with('success', 'Autor atualizado com sucesso!');
    
    }

    public function destroy($id){
        $autor = Autor::findOrFail($id);
        $autor->delete();
        return redirect('/autores')->with('success', 'Autor excluído com sucesso!');
    }
}
