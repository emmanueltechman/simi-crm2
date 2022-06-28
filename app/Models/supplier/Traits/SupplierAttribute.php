<?php

namespace App\Models\supplier\Traits;

/**
 * Class SupplierAttribute.
 */
trait SupplierAttribute
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
         '.$this->getViewButtonAttribute("supplier-manage", "biller.suppliers.show").'
                '.$this->getEditButtonAttribute("supplier-data", "biller.suppliers.edit").'
                '.$this->getDeleteButtonAttribute("supplier-data", "biller.suppliers.destroy").'
                ';
    }
}
