<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = "product_images";
    public $timestamps = false;
    protected $primaryKey = 'id';
}
