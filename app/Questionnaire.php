<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = "questionnaire";
    public $timestamps = false;

    public function QuesWithFields()
    {
        return $this->hasMany('App\QuestionnaireFields', 'questionnaire_id','id');
    }

}
