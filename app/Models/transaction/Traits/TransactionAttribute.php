<?php

namespace App\Models\transaction\Traits;

/**
 * Class TransactionAttribute.
 */
trait TransactionAttribute
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
         '.$this->getViewButtonAttribute("transaction-manage", "biller.transactions.show").'
            
                '.$this->getDeleteButtonAttribute("transaction-data", "biller.transactions.destroy").'
                ';
    }
}
