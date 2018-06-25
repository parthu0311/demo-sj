<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    public $timestamps = false;

     public function QuestionnaireAnswered()
    {
        return $this->hasMany('App\QuestionnaireAnswered', 'product_id','id');
    }

    public function Image()
    {
        return $this->hasMany('App\ProductImages', 'product_id','id');
    }

}
