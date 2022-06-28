<?php

namespace App\Models\misc\Traits;

use App\Models\project\Task;
use App\Models\project\TaskRelations;

/**
 * Class MiscRelationship
 */
trait MiscRelationship
{

       public function count_items() {
       return $this->hasManyThrough(Task::class,TaskRelations::class,'rid','id','id','todolist_id')->where('related','=',2);
    }

}
