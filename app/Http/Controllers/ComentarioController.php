<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'nullable|string',
            'pontuacao' => 'nullable|integer|min:1|max:5',
            'livro_id' => 'required|exists:livros,id',
        ]);

        if (!$request->comentario && !$request->pontuacao) {
            return back()->withErrors(['comentario' => 'É necessário preencher um comentário ou pontuação.']);
        }

        Comentario::create([
            'comentario' => $request->comentario,
            'pontuacao' => $request->pontuacao,
            'livro_id' => $request->livro_id,
            'leitor_id' => Auth::id(),
        ]);

        return redirect()->route('livros.show', $request->livro_id)->with('success', 'Comentário adicionado!');
    }

    public function destroy($comentario_id)
    {
        $comentario = Comentario::find($comentario_id);

        if ($comentario->leitor_id === Auth::id()) {
            $comentario->delete();
            return back()->with('success', 'Comentário excluído!');
        }

        return back()->withErrors(['error' => 'Você não pode excluir este comentário.']);
    }

    public function desativar($comentario_id)
    {
        $comentario = Comentario::find($comentario_id);

        if ($comentario) {
            $comentario->ativo = false;
            $comentario->save();
            return back()->with('success', 'Comentário desativado com sucesso!');
        }

        return back()->withErrors(['error' => 'Comentário não encontrado.']);
    }
}
