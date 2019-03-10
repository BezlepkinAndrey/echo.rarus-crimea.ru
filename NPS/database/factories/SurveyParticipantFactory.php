<?php

use App\SurveyParticipant;
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


$factory->define(SurveyParticipant::class, function (Faker $faker) {

    $secretKey = $faker->email;
    return [
        'secret_key' => $secretKey,
        'tip'        => $secretKey,
    ];
});
