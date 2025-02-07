<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Livro;
use App\User;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = ['comentario', 'pontuacao', 'ativo', 'livro_id', 'leitor_id'];

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }

    public function leitor()
    {
        return $this->belongsTo(User::class, 'leitor_id');
    }
}
