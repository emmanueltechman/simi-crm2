<?php

namespace App\Models\market\Traits;

/**
 * Class InvoiceAttribute.
 */
trait SalesChannelAttribute
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
         '.$this->getViewButtonAttribute("business_settings", "biller.markets.show").'
                '.$this->getEditButtonAttribute("business_settings", "biller.markets.edit2").'
           
                <a href="'.route('biller.markets.destroy', $this).'?id='.$this->id.'" 
                    class="btn btn-danger round" data-method="delete"
                    data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                    data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                    data-trans-title="'.trans('strings.backend.general.are_you_sure').'" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i  class="fa fa-trash"></i>
                </a>';
    }


}
