<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubCategory;
use Faker\Generator as Faker;

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        "name" => $faker->unique()->randomElement([
          'Alimentos',
          'Accesorios',
          'Estetica e higiene',
          'Salud',
          'Snacks',
        ]),
    ];
});
