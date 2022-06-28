<?php

namespace App\Models\product\Traits;


use App\Models\product\Product;
use App\Models\product\ProductVariation;
use App\Models\warehouse\Warehouse;

/**
 * Class ProductRelationship
 */
trait ProductMetaRelationship
{


    public function product()
    {
        return $this->hasOne(ProductVariation::class, 'id', 'rel_id')->withoutGlobalScopes();
    }

    public function product_serial()
    {
        return $this->belongsTo(ProductVariation::class, 'ref_id', 'id')->where('parent_id','=',0)->withoutGlobalScopes();
    }



        public function product_standard()
    {
        //return $this->hasOneThrough(ProductVariation::class, Product::class, 'id', 'id', 'id', 'product_id')->withoutGlobalScopes();
          return $this->hasOneThrough(Product::class,ProductVariation::class,'product_id','id','ref_id','id')->withoutGlobalScopes();
    }


    public function from_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'ref_id');
    }

    public function to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'value2');
    }


}
