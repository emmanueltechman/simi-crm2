<?php

namespace App\Models\warehouse\Traits;

/**
 * Class WarehouseAttribute.
 */
trait WarehouseAttribute
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
         '.$this->getViewButtonAttribute("manage-warehouse", "biller.warehouses.show").'
                '.$this->getEditButtonAttribute("warehouse-data", "biller.warehouses.edit").'
                '.$this->getDeleteButtonAttribute("warehouse-data", "biller.warehouses.destroy").'
                ';
    }
}
