<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUserMaster extends Model
{
    protected $table = "tbl_adminuser";
    public $timestamps = false;

    public function roll(){
        return $this->hasOne('App\RoleMaster','role_id','role_id');
    }

}
