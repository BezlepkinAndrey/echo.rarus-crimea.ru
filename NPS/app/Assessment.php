<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{

    public function surveyParticipants()
    {
        return $this->morphTo();
    }

}
