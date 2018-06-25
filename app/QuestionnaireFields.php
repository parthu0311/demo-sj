<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireFields extends Model
{
    protected $table = "questionnaire_fields";
    public $timestamps = false;

    public function questionnaire_fields_values()
    {
        return $this->hasMany('App\QuestionnaireFieldsValues', 'questionnaire_fields_id','id');
    }

}
