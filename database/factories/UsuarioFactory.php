<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Usuario;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'senha' => 'senha123', // Senha fictícia
        'tipoUsuario' => $this->faker->randomElement(['administrador', 'leitor', 'visitante']),
        'remember_token' => Str::random(10)
    ];
});
