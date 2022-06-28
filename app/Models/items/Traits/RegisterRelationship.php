<?php

namespace App\Models\items\Traits;


/**
 * Class CustomerRelationship
 */
trait RegisterRelationship
{


    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User')->withoutGlobalScopes();
    }


}
