<?php

namespace App\Models\project\Traits;

use App\Models\event\Event;
use App\Models\event\EventRelation;
use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\project\Project;
use App\Models\project\ProjectRelations;
use App\Models\project\TaskRelations;

/**
 * Class TaskRelationship
 */
trait TaskRelationship
{

    public function tags()
    {
        return $this->hasManyThrough(Misc::class, TaskRelations::class, 'todolist_id', 'id', 'id', 'rid')->where('section', '=', 1);
    }

      public function events()
    {
        return $this->hasOneThrough(Event::class, EventRelation::class, 'r_id','id','id','event_id')->where('related', '=', 2)->withoutGlobalScopes();
    }

    public function task_status()
    {
        return $this->hasOne(Misc::class, 'id', 'status')->where('section', '=', 2);
    }

    public function users()
    {
        return $this->hasManyThrough(Hrm::class, TaskRelations::class, 'todolist_id', 'id', 'id', 'rid');
    }

    public function creator()
    {
        return $this->hasOne(Hrm::class, 'id', 'creator_id');
    }

    public function project()
    {
        return $this->hasMany(ProjectRelations::class, 'rid','id');
    }

       public function projects()
    {
        return $this->hasManyThrough(Project::class, ProjectRelations::class, 'rid','id','id','project_id')->where('related','=',4)->withoutGlobalScopes();
    }

}
