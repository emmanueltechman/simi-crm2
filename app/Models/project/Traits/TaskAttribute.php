<?php

namespace App\Models\project\Traits;

/**
 * Class TaskAttribute.
 */
trait TaskAttribute
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
         '.$this->getViewButtonAttribute("task-manage", "biller.tasks.show").'
                '.$this->getEditButtonAttribute("task-edit", "biller.tasks.edit").'
                '.$this->getDeleteButtonAttribute("task-delete", "biller.tasks.destroy").'
                ';
    }
}
