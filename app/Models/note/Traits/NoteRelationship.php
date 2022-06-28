<?php

namespace App\Models\note\Traits;

use App\Models\hrm\Hrm;
use App\Models\project\ProjectRelations;

/**
 * Class NoteRelationship
 */
trait NoteRelationship
{
    public function project()
    {
        return $this->hasOne(ProjectRelations::class, 'rid', 'id')->where('related', '=', 6);
    }

        public function creator()
    {
        return $this->hasOne(Hrm::class, 'id', 'user_id');
    }
}
