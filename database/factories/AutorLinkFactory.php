<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\Models\AutorLink;
use Faker\Generator as Faker;
use App\Models\Autor;

$factory->define(AutorLink::class, function(Faker $faker) {
    return [
        'autor_id' => function () {
            return factory(Autor::class)->create()->id;
        },
        'site_nome' => $this->faker->word,
        'site_link' => $this->faker->url,
        
    ];
});
