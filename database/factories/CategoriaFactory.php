<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Categoria;
use Faker\Generator as Faker;

$factory->define(Categoria::class, function (Faker $faker) {
    return [
        'nome' => $this->faker->word,
        'descricao' => $this->faker->sentence,
        'numero_livros' => $this->faker->numberBetween(1, 10),
    ];
});
