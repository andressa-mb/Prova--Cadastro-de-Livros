<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Livro;
use App\User;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $fillable = ['livro_id', 'leitor_id'];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function leitor()
    {
        return $this->belongsTo(User::class, 'leitor_id');
    }
}
