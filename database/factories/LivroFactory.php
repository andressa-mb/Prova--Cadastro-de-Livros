<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Livro;
use Faker\Generator as Faker;

$factory->define(Livro::class, function (Faker $faker) {
    return [
        'titulo' => $this->faker->sentence,
        'editora' => $this->faker->company,
        'data_publicacao' => $this->faker->date(),
        'keywords' => $this->faker->words(3, true),
    ];
});
