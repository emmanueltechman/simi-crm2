<?php

namespace App\Models\tag\Traits;

/**
 * Class TagAttribute.
 */
trait TagAttribute
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
         '.$this->getViewButtonAttribute("edit-tag", "biller.tags.show").'
                '.$this->getEditButtonAttribute("edit-tag", "biller.tags.edit").'
                '.$this->getDeleteButtonAttribute("delete-tag", "biller.tags.destroy").'
                ';
    }
}
