<?php

use Illuminate\Database\Seeder;
use App\Models\Autor;
use App\Models\AutorLink;

class AutorSeeder extends Seeder
{
    public function run()
    {
        // Pegue todos os autores existentes
        $autores = Autor::all();

        // Verifique se há autores cadastrados para associar os links
        if ($autores->isEmpty()) {
            // Se não houver autores, crie alguns para teste
            $autores = factory(Autor::class, 10)->create();
        }

        // Crie 10 links para cada autor
        $autores->each(function ($autor) {
            // Crie 10 links para cada autor, associando o autor_id
            factory(AutorLink::class, 10)->create([
                'autor_id' => $autor->id,  // Associando o link ao autor
            ]);
        });
    }
}
