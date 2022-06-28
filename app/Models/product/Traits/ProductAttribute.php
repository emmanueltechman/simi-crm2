<?php

namespace App\Models\product\Traits;

/**
 * Class ProductAttribute.
 */
trait ProductAttribute
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
         '.$this->getViewButtonAttribute("product-manage", "biller.products.show").'
                '.$this->getEditButtonAttribute("product-edit", "biller.products.edit").'
                '.$this->getDeleteButtonAttribute("product-delete", "biller.products.destroy",'table').'
                ';
    }
}
