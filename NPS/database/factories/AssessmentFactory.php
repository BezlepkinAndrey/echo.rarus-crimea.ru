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

$factory->define(Assessment::class, function (Faker $faker) {

    $date = $faker->dateTimeBetween('-5 years');
    return [
        'assessment' => (int)$faker->randomFloat(0, 1, 10),
        'created_at' => date_timestamp_get($date)
    ];
});