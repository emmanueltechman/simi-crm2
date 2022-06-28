<?php

namespace App\Models\project\Traits;

use App\Models\customer\Customer;
use App\Models\event\Event;
use App\Models\event\EventRelation;
use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\note\Note;
use App\Models\project\Project;
use App\Models\project\ProjectLog;
use App\Models\project\ProjectMeta;
use App\Models\project\ProjectMileStone;
use App\Models\project\ProjectRelations;
use App\Models\project\Task;

/**
 * Class ProjectRelationship
 */
trait ProjectRelationship
{
    public function tags()
    {
        return $this->hasManyThrough(Misc::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('section', '=', 1)->withoutGlobalScopes();
    }

    public function task_status()
    {
        return $this->hasOne(Misc::class, 'id', 'status')->where('section', '=', 2)->withoutGlobalScopes();
    }

    public function users()
    {
        return $this->hasManyThrough(Hrm::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 2)->withoutGlobalScopes();
    }

    public function creator()
    {
        return $this->hasOneThrough(Hrm::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 3)->withoutGlobalScopes();
    }

        public function customer()
    {
        return $this->hasOneThrough(Customer::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 8)->withoutGlobalScopes();
    }

    public function tasks()
    {
        return $this->hasOneThrough(Task::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 4)->withoutGlobalScopes();
    }

    public function tasks_status()
    {
        return $this->hasOneThrough(Task::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 4)->withoutGlobalScopes();
    }

    public function milestones()
    {
        return $this->hasMany(ProjectMileStone::class, 'project_id', 'id')->orderBy('due_date', 'desc');
    }

    public function history()
    {
        return $this->hasMany(ProjectLog::class, 'project_id', 'id')->orderBy('id', 'desc');
    }

    public function attachment()
    {
        return $this->hasMany(ProjectMeta::class, 'project_id', 'id')->where('meta_key', '=', 1)->orderBy('id', 'desc')->withoutGlobalScopes();
    }

        public function notes()
    {
         return $this->hasManyThrough(Note::class, ProjectRelations::class, 'project_id', 'id', 'id', 'rid')->where('related', '=', 6)->withoutGlobalScopes();
    }

        public function project()
    {
        return $this->hasOne(Project::class, 'project_id', 'id')->withoutGlobalScopes();
    }

          public function events()
    {
        return $this->hasOneThrough(Event::class, EventRelation::class, 'r_id','id','id','event_id')->where( 'related','=', 1)->withoutGlobalScopes();
    }






}
