<?php

namespace App\Models\account\Traits;

/**
 * Class AccountAttribute.
 */
trait AccountAttribute
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
         '.$this->getViewButtonAttribute("account-manage", "biller.accounts.show").'
                '.$this->getEditButtonAttribute("account-data", "biller.accounts.edit").'
                '.$this->getDeleteButtonAttribute("account-data", "biller.accounts.destroy").'
                ';
    }
}
