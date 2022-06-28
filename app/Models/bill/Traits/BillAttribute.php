<?php

namespace App\Models\bill\Traits;

/**
 * Class InvoiceAttribute.
 */
trait BillAttribute
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
         '.$this->getViewButtonAttribute("invoice-manage", "biller.invoices.show").'
                '.$this->getEditButtonAttribute("invoice-edit", "biller.invoices.edit").'
                '.$this->getDeleteButtonAttribute("invoice-delete", "biller.invoices.destroy").'
                ';
    }
}
