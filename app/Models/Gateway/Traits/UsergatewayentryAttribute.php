<?php

namespace App\Models\Gateway\Traits;

/**
 * Class UsergatewayentryAttribute.
 */
trait UsergatewayentryAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.usergatewayentries.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.usergatewayentries.edit").'
                '.$this->getDeleteButtonAttribute("business_settings", "biller.usergatewayentries.destroy").'
                ';
    }

            public function setSurchargeAttribute($value)
    {
        $this->attributes['surcharge'] = numberClean($value);
    }
        public function getSurchargeAttribute($value)
    {
        return $this->attributes['surcharge'] = numberFormat($value);
    }
}
