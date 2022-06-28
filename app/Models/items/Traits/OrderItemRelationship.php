<?php

namespace App\Models\items\Traits;


/**
 * Class CustomerRelationship
 */
trait OrderItemRelationship
{

       public function product()
    {
        return $this->belongsTo('App\Models\product\ProductVariation','product_id','product_id');
    }

           public function variation()
    {
        return $this->belongsTo('App\Models\product\ProductVariation','product_id','id')->withoutGlobalScopes();
    }

}
