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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Reservations\Premiere::class, function (Faker\Generator $faker) {
    return [
        'name'=> $faker->text($maxNbChars = 50),
        'detail'=> $faker->text($maxNbChars = 150),
        'image'=> $faker->imageUrl(256, 256, 'sports')
    ];
});

$factory->define(App\Models\Reservations\PremiereTime::class, function (Faker\Generator $faker) {
    $n = $faker->numberBetween(1,23);
    return [
        'chair_id'=> App\Models\Reservations\Chair::inRandomOrder()->first()->id,
        'date'=> date('Y-m-d'),
        'hour_initial'=> $n.':00:00',
        'hour_final'=> ($n+1).':00:00',
        'ticket_price'=> $faker->numerify("#####"),
    ];
});
