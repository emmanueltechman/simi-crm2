<?php

namespace App\Models\Access\Permission\Traits\Attribute;

/**
 * Class PermissionAttribute.
 */
trait PermissionAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                    '.$this->getEditButtonAttribute('edit-permission', 'admin.access.permission.edit').'             
                </div>';
    }
}
