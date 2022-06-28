<?php

namespace App\Models\prefix\Traits;

/**
 * Class PrefixAttribute.
 */
trait PrefixAttribute
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
    
                '.$this->getEditButtonAttribute("business_settings", "biller.prefixes.edit").'
              
                ';
    }
}
