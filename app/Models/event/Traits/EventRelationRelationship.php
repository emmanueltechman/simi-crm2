<?php

namespace App\Models\event\Traits;

use App\Models\event\Event;

/**
 * Class EventRelationship
 */
trait EventRelationRelationship
{
 public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id');
    }
}
