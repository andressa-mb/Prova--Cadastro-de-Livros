<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livros';
    protected $fillable = ['titulo', 'editora', 'data_publicacao', 'keywords'];

    // Relacionamento: um livro pode ter vários autores
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'livro_id', 'autor_id');
    }

    // Relacionamento: um livro pode pertencer a várias categorias
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'livro_categoria', 'livro_id', 'categoria_id');
    }
}
