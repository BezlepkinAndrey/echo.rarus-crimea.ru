<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{

    /**
     *
     * Метод устанавливает возвращает владельца оценки
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function surveyParticipants()
    {
        return $this->morphTo();
    }

}
