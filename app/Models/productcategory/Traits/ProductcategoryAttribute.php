<?php

namespace App\Models\productcategory\Traits;

/**
 * Class ProductcategoryAttribute.
 */
trait ProductcategoryAttribute
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
         '.$this->getViewButtonAttribute("productcategory-manage", "biller.productcategories.show").'
                '.$this->getEditButtonAttribute("productcategory-data", "biller.productcategories.edit").'
                '.$this->getDeleteButtonAttribute("productcategory-data", "biller.productcategories.destroy").'
                ';
    }
}
