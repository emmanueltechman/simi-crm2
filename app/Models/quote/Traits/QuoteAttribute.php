<?php

namespace App\Models\quote\Traits;

/**
 * Class QuoteAttribute.
 */
trait QuoteAttribute
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
         '.$this->getViewButtonAttribute("quote-edit", "biller.quotes.show").'
                '.$this->getEditButtonAttribute("quote-edit", "biller.quotes.edit").'
                '.$this->getDeleteButtonAttribute("quote-delete", "biller.quotes.destroy").'
                ';
    }
}
