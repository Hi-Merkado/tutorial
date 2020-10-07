<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNAVAILABLE_PRODUCT]),
        'image' => $faker->randomElement(['https://picsum.photos/id/1/367/267', 'https://picsum.photos/id/0/367/267', 'https://picsum.photos/id/1000/367/267']),
        'seller_id' => User::all()->random()->id
    ];
});
