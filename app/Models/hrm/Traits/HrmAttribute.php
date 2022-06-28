<?php

namespace App\Models\hrm\Traits;

/**
 * Class HrmAttribute.
 */
trait HrmAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/5.4/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '
         ' . $this->getViewButtonAttribute("manage-hrm", "biller.hrms.show") . '
                ' . $this->getEditButtonAttribute("manage-hrm", "biller.hrms.edit") . '
            
                ';
    }

    public function getPictureAttribute()
    {
        if (!$this->attributes['picture']) {
            return 'user.png';
        }

        return $this->attributes['picture'];
    }

    public function getSignatureAttribute()
    {
        if (!$this->attributes['signature']) {
            return 'sign.png';
        }
        return $this->attributes['signature'];
    }
}
