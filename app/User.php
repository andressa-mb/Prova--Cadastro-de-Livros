<?php

namespace App;

use App\Models\Comentario;
use App\Models\Favorito;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nome', 'email', 'password', 'tipoUsuario'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'livro_id', 'leitor_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'livro_id', 'leitor_id');
    }

}
