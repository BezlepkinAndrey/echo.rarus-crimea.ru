<?php

use App\SurveyParticipant;
use App\Assessment;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SurveyParticipant::class, 1000)->create()->each(function ($u) {
            $u->assessments()->saveMany(factory(App\Assessment::class, random_int(0,20))->make());
        });

    }
}
