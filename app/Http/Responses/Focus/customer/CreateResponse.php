<?php

namespace App\Http\Responses\Focus\customer;

use App\Models\customer\Customer;
use App\Models\customergroup\Customergroup;
use App\Models\customfield\Customfield;
use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        $input = $request->only('rel_type', 'rel_id');
         $customergroups=Customergroup::all();
         $customer='';
         if(isset($input['rel_id']))$customer=Customer::find($input['rel_id']);
          $fields=custom_fields(Customfield::where('module_id', '1')->get()->groupBy('field_type'));
        return view('focus.customers.create',compact('customergroups','fields','input','customer'));

    }
}