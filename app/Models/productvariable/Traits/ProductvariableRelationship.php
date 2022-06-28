<?php

namespace App\Models\productvariable\Traits;

/**
 * Class ProductvariableRelationship
 */
trait ProductvariableRelationship
{
     public function variation() {

        return $this->belongsTo('App\Models\productvariable\Productvariable','id','sub');
    }

}
