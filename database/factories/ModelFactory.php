<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Taggy\Models\Tag::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->colorName;

    return [
      'name' => $name,
      'slug' => str_slug($name)
    ];
});
