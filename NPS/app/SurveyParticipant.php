<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyParticipant extends Model
{
    /**
     * Метод возвращает оценки участника опроса
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function assessments()
    {
        return $this->morphMany(Assessment::Class, 'owner');
    }
}
