<?php

namespace App\Models\customer\Traits;

/**
 * Class CustomerAttribute.
 */
trait CustomerAttribute
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
         '.$this->getViewButtonAttribute("manage-customer", "biller.customers.show").'
                '.$this->getEditButtonAttribute("edit-customer", "biller.customers.edit").'
                '.$this->getDeleteButtonAttribute("delete-customer", "biller.customers.destroy",'table').'
                ';
    }
}
