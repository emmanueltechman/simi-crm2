<?php

namespace App\Models\bank\Traits;

/**
 * Class BankAttribute.
 */
trait BankAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.banks.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.banks.edit").'
                '.$this->getDeleteButtonAttribute("business_settings", "biller.banks.destroy").'
                ';
    }
}
