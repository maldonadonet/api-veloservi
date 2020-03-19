<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Producto::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->randomElement(['Producto1','Producto2','Producto3','Producto4','Producto5']),
        'descripcion' => $faker->text,
        'categoria' => $faker->randomElement(['Tienda','Farmacia','Ropa','Zapatos']),
        'precio' => $faker->randomFloat(2,10,500),
        'stock' => $faker->randomDigit,
        'usuario_id' => $faker->randomDigitNot(5),
        'descuento' => $faker->randomFloat(2,1,10),
        'puntos' => $faker->randomDigitNot(5),
        'status' => $faker->randomElement(['activo']),
        'foto' => $faker->imageUrl(640,480),
        'created_at' => $faker->date('Y-m-d','now'),
    ];
});
