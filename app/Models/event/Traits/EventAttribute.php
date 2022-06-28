<?php

namespace App\Models\event\Traits;

/**
 * Class EventAttribute.
 */
trait EventAttribute
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
         '.$this->getViewButtonAttribute("edit-event", "biller.events.show").'
                '.$this->getEditButtonAttribute("edit-event", "biller.events.edit").'
                '.$this->getDeleteButtonAttribute("delete-event", "biller.events.destroy").'
                ';
    }
}
