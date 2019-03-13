<?php

use App\Assessment;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**
 * Фабрика зоздания оценок участников опроса
 */
$factory->define(Assessment::class, function (Faker $faker) {

    $date = $faker->dateTimeBetween('-5 month');
    return [
        'assessment' => random_int(random_int(random_int(1, 8), 9), 10),
        'created_at' => date_timestamp_get($date)
    ];
});