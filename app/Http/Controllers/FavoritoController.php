<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;

class FavoritoController extends Controller
{
    public function store($livro_id)
    {
        $favorito = Favorito::where('livro_id', $livro_id)
            ->where('leitor_id', Auth::id())
            ->first();

        if ($favorito) {
            $favorito->delete();
            return redirect()->back()->with('success', 'Livro removido dos favoritos.');
        } else {
            Favorito::create([
                'livro_id' => $livro_id,
                'leitor_id' => Auth::id(),
            ]);
            return redirect()->back()->with('success', 'Livro adicionado aos favoritos.');
        }
    }
}
