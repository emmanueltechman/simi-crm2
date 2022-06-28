<?php

namespace App\Models\items\Traits;


/**
 * Class CustomerRelationship
 */
trait CustomentryRelationship
{

     public function customfield()
    {
        return $this->hasOne('App\Models\customfield\Customfield','id','custom_field_id')->withoutGlobalScopes();
    }

}
