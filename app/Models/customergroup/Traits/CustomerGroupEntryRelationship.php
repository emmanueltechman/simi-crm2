<?php

namespace App\Models\customergroup\Traits;

/**
 * Class CustomergroupRelationship
 */
trait CustomerGroupEntryRelationship
{
    public function customer()
    {
        return $this->hasMany('App\Models\customer\Customer');
    }

    public function customer_details()
    {
        return $this->hasOne('App\Models\customer\Customer','id','customer_id');
    }

    public function group_data()
    {
        return $this->belongsTo('App\Models\customergroup\Customergroup','customer_group_id','id');
    }


}
