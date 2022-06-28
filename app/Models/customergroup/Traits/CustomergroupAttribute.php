<?php

namespace App\Models\customergroup\Traits;

/**
 * Class CustomergroupAttribute.
 */
trait CustomergroupAttribute
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
         '.$this->getViewButtonAttribute("manage-customergroup", "biller.customergroups.show").'
                '.$this->getEditButtonAttribute("edit-customergroup", "biller.customergroups.edit").'
                '.$this->getDeleteButtonAttribute("delete-customergroup", "biller.customergroups.destroy").'
                ';
    }
}
