<?php

namespace App\Models\employee\Traits;


/**
 * Class HrmRelationship
 */
trait RoleUserRelationship
{
    public function role()
    {
        return $this->belongsTo(config('access.role_user_table'), 'user_id', 'role_id');
    }

}
