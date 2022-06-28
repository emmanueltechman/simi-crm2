<?php

namespace App\Models\department\Traits;

/**
 * Class DepartmentAttribute.
 */
trait DepartmentAttribute
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
         '.$this->getViewButtonAttribute("department-manage", "biller.departments.show").'
                '.$this->getEditButtonAttribute("department-data", "biller.departments.edit").'
                '.$this->getDeleteButtonAttribute("department-data", "biller.departments.destroy").'
                ';
    }
}
