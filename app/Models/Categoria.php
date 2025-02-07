<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nome', 'descricao', 'numero_livros'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_categoria', 'categoria_id', 'livro_id');
    }
}
