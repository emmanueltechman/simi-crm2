<?php

namespace App\Models\currency\Traits;

/**
 * Class CurrencyAttribute.
 */
trait CurrencyAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.currencies.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.currencies.edit").'
                '.$this->getDeleteButtonAttribute("business_settings", "biller.currencies.destroy").'
                ';
    }
        public function setRateAttribute($value)
    {
        $this->attributes['rate'] = numberClean($value);
    }
        public function getRateAttribute($value)
    {
        return $this->attributes['rate'] = numberFormat($value);
    }
}
