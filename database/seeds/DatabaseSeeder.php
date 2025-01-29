<?php

use Illuminate\Database\Seeder;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\Categoria;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $autores = factory(Autor::class, 10)->create();

        $livros = factory(Livro::class, 20)->create();

        $categorias = factory(Categoria::class, 5)->create();

        factory(Usuario::class, 10)->create();

        foreach ($livros as $livro) {
            $livro->autores()->attach(
                $autores->random(2)->pluck('id')->toArray()
            );
        }
        foreach ($livros as $livro) {
            $livro->categorias()->attach(
                $categorias->random(2)->pluck('id')->toArray()
            );
        }
    }
}
