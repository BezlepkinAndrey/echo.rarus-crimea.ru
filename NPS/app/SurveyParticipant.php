<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyParticipant extends Model
{
    public function assessments()
    {
        return $this->morphMany(Assessment::Class, 'owner');
    }
}
