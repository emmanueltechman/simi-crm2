<?php

namespace App\Models\customfield\Traits;

/**
 * Class CustomfieldAttribute.
 */
trait CustomfieldAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.customfields.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.customfields.edit").'
                '.$this->getDeleteButtonAttribute("business_settings", "biller.customfields.destroy").'
                ';
    }
}
