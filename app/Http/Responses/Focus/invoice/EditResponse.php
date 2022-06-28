<?php

namespace App\Http\Responses\Focus\invoice;


use App\Models\account\Account;
use App\Models\customer\Customer;
use App\Models\customfield\Customfield;
use App\Models\invoice\Invoice;
use App\Models\items\CustomEntry;

use App\Models\market\ChannelBill;
use App\Models\market\SalesChannel;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\invoice\Invoice
     */
    protected $invoices;

    /**
     * @param App\Models\invoice\Invoice $invoices
     */
    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {

        $fields = Customfield::where('module_id', '=', 2)->get()->groupBy('field_type');
        $fields_raw = array();

        if (isset($fields['text'])) {
            foreach ($fields['text'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 2)->where('rid', '=', $this->invoices->id)->first();
                $fields_raw['text'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }
        if (isset($fields['number'])) {
            foreach ($fields['number'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 2)->where('rid', '=', $this->invoices->id)->first();
                $fields_raw['number'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }

        $fields_data = custom_fields($fields_raw);

        if ($this->invoices->i_class == 1) {

               $input = $request->only(['sub', 'p']);
            $customer = Customer::first();
            $accounts = Account::all();

            $input['sub'] = false;
            $last_invoice = Invoice::orderBy('id', 'desc')->where('i_class', '=', 1)->first();
                $action=route('biller.invoices.pos_update',$this->invoices->id);

            return view('focus.invoices.pos.edit')->with(array('last_invoice' => $last_invoice, 'sub' => $input['sub'], 'p' => $request->p, 'accounts' => $accounts, 'customer' => $customer,'invoices' => $this->invoices,'action'=>$action))->with(bill_helper(1, 2))->with(product_helper());

                //return view('focus.invoices.pos.edit')->with(['invoices' => $this->invoices])->with(bill_helper(1))->with(compact('fields_data', 'sub'));

        } else {
            if ($this->invoices->i_class == 0) {
                $sub['prefix'] = prefix(1);
            } else if ($this->invoices->i_class > 1) {
                $sub['prefix'] = prefix(6);
            }

            $salesChannels=SalesChannel::all();
            $current_salesChannel=ChannelBill::where('bill_id','=',$this->invoices->id)->where('ref','=',1)->first();

            return view('focus.invoices.edit')->with(['invoices' => $this->invoices])->with(bill_helper(1))->with(compact('fields_data', 'sub','salesChannels','current_salesChannel'));
        }
    }
}