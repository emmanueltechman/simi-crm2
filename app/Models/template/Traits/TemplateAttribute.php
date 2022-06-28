<?php

namespace App\Models\template\Traits;

/**
 * Class TemplateAttribute.
 */
trait TemplateAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.templates.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.templates.edit");
    }


}
