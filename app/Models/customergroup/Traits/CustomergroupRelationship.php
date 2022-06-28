<?php

namespace App\Models\customergroup\Traits;

/**
 * Class CustomergroupRelationship
 */
trait CustomergroupRelationship
{
public function customers()
    {
        return $this->hasMany('App\Models\customergroup\CustomerGroupEntry','customer_group_id');
    }
}
