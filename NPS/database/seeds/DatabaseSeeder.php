<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Загрузка данных в БД
     *
     * @return void
     */
    public function run()
    {
        factory(App\SurveyParticipant::class, 100)->create()->each(function ($u) {
            $u->assessments()->saveMany(factory(App\Assessment::class, random_int(0, 5))->make());
        });

    }
}
