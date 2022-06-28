<?php

namespace App\Models\order\Traits;

/**
 * Class OrderAttribute.
 */
trait OrderAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/5.4/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        $btn='';
       if (access()->allow('creditnote-manage') OR access()->allow('stockreturn-manage') ) $btn.= '<a href="'.route("biller.orders.show", $this).'" class="btn btn-primary round" data-toggle="tooltip" data-placement="top" title="View">
                    <i  class="fa fa-eye"></i>
                </a> ';
       if (access()->allow('data-creditnote') OR access()->allow('stockreturn-data') ) $btn.= '<a href="'.route("biller.orders.edit", $this).'" class="btn btn-warning round" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i  class="fa fa-pencil "></i>
                </a> <a href="'.route("biller.orders.destroy", $this).'" 
                    class="btn btn-danger round" table-method="delete"
                    data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                    data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                    data-trans-title="'.trans('strings.backend.general.are_you_sure').'" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i  class="fa fa-trash"></i>
                </a>
                ';

        return $btn;
    }
}
