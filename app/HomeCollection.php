<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeCollection extends Model
{
    protected $table = "home_collection";
    public $timestamps = false;

    public function home_collection_product()
    {
        return $this->hasMany('App\HomeCollectionProduct', 'collection_id','id');
    }
}
