<?php

namespace App\Models\items\Traits;


/**
 * Class CustomerRelationship
 */
trait InvoiceItemRelationship
{

       public function product()
    {
        return $this->belongsTo('App\Models\product\ProductVariation','product_id','product_id')->withoutGlobalScopes();
    }

           public function variation()
    {
        return $this->belongsTo('App\Models\product\ProductVariation','product_id','id')->withoutGlobalScopes();
    }



}
