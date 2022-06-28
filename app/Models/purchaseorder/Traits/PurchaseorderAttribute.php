<?php

namespace App\Models\purchaseorder\Traits;

/**
 * Class PurchaseorderAttribute.
 */
trait PurchaseorderAttribute
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
         '.$this->getViewButtonAttribute("purchaseorder-manage", "biller.purchaseorders.show").'
                '.$this->getEditButtonAttribute("purchaseorder-data", "biller.purchaseorders.edit").'
                '.$this->getDeleteButtonAttribute("purchaseorder-data", "biller.purchaseorders.destroy",'table').'
                ';
    }
}
