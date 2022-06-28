<?php

namespace App\Models\hrm\Traits;


use App\Models\Access\Permission\Permission;
use App\Models\Access\Permission\PermissionRole;
use App\Models\Access\Permission\PermissionUser;
use App\Models\Access\Role\Role;
use App\Models\Access\User\UserProfile;
use App\Models\employee\RoleUser;
use App\Models\hrm\Hrm;
use App\Models\hrm\HrmMeta;
use App\Models\project\Project;
use App\Models\quote\Quote;
use App\Models\transaction\Transaction;

/**
 * Class HrmRelationship
 */
trait AttendanceRelationship
{



    public function user()
    {
        return $this->hasOne(Hrm::class, 'id','user_id');
    }




}
