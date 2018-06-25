<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuMaster extends Model
{
    protected $table = "menu_master";

    protected $fillable = array();
    protected $guarded = array('id');

    public function WithAction(){
        return $this->belongsTo('App\ActionMaster', 'menu_id','menu_id');
    }
}
