<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = "product_variant";
    public $timestamps = false;

    public function Image()
    {
        return $this->hasMany('App\ProductVariantImage', 'variant_id','id');
    }
}
