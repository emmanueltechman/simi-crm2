<?php

namespace App\Models\additional\Traits;

/**
 * Class AdditionalAttribute.
 */
trait AdditionalAttribute
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
         ' . $this->getViewButtonAttribute("business_settings", "biller.additionals.show") . '
                ' . $this->getEditButtonAttribute("business_settings", "biller.additionals.edit") . '
                ' . $this->getDeleteButtonAttribute("business_settings", "biller.additionals.destroy") . '
                ';
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = numberClean($value);
    }

     public function getValueAttribute($value)
    {
        return $this->attributes['value'] = numberFormat($value);
    }
}
