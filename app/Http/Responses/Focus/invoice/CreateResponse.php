<?php

namespace App\Http\Responses\Focus\invoice;

use App\Models\hrm\Hrm;
use App\Models\invoice\Invoice;
use App\Models\market\SalesChannel;
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
        $input = $request->only(['sub','p']);
        if (isset($input['sub'])) {
            $last_invoice = Invoice::orderBy('id', 'desc')->where('i_class', '>', 1)->first();
        } else {
            $input['sub']=false;
            $last_invoice = Invoice::orderBy('id', 'desc')->where('i_class', '=', 0)->first();
        }
        $employee='';
        $salesChannel=SalesChannel::all();

        if(feature(1)['value1']=='yes') $employee=Hrm::all();

        return view('focus.invoices.create')->with(array('last_invoice' => $last_invoice,'sub'=>$input['sub'],'p'=>$request->p,'salesChannels'=>$salesChannel,'employees'=>$employee))->with(bill_helper(1, 2));
    }
}
