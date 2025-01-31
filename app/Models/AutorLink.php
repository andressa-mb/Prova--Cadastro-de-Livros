<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutorLink extends Model
{
    protected $fillable = ['autor_id', 'site_nome', 'site_link'];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }
}
