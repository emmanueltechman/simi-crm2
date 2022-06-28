<?php

namespace App\Models\warehouse\Traits;

use App\Models\product\Product;
use App\Models\product\ProductVariation;
use DB;
/**
 * Class WarehouseRelationship
 */
trait WarehouseRelationship
{
     public function products()
    {
        return $this->hasMany(ProductVariation::class)->select([DB::raw('qty*price as total_value'),'qty']);
    }
}
