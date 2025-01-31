<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\Models\Autor;
use Faker\Generator as Faker;

$factory->define(Autor::class, function(Faker $faker) {
    return [
        'nome' => $this->faker->name,
        'bio' => $this->faker->paragraph,
        'foto' => $this->faker->imageUrl(),
    ];
});
