<?php

namespace App\Models\Access\Permission\Traits\Relationship;

use App\Models\Access\Permission\Permission;

/**
 * Class PermissionRelationship.
 */
trait PermissionRoleRelationship
{
    /**
     * @return mixed
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
