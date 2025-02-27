<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comentario;
use App\Models\Favorito;

class Livro extends Model
{
    protected $table = 'livros';
    protected $fillable = ['titulo', 'editora', 'data_publicacao', 'keywords', 'capa'];

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'livro_id', 'autor_id');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'livro_categoria', 'livro_id', 'categoria_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'livro_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'livro_id');
    }
}
