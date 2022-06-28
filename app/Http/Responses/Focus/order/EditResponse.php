<?php

namespace App\Http\Responses\Focus\order;
use App\Models\customfield\Customfield;
use App\Models\items\CustomEntry;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\order\Order
     */
    protected $orders;

    /**
     * @param App\Models\order\Order $orders
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
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

           $fields = Customfield::where('module_id', 5)->get()->groupBy('field_type');
        $fields_raw = array();

        if (isset($fields['text'])) {
            foreach ($fields['text'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 2)->where('rid', '=', $this->orders->id)->first();
                $fields_raw['text'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }
        if (isset($fields['number'])) {
            foreach ($fields['number'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 2)->where('rid', '=', $this->orders->id)->first();
                $fields_raw['number'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }

        $fields_data = custom_fields($fields_raw);

                switch ($this->orders->i_class) {
            case 2:
                 if (!access()->allow('creditnote-manage')) exit();
                $words['title'] = trans('orders.credit_notes_manage');
                $words['prefix'] = prefix(7);
                $words['properties'] = trans('orders.credit_notes_properties');
                $words['person_details'] = trans('invoices.client_details');
                $words['enter_person'] = trans('invoices.enter_customer');
                $words['search_person'] = trans('invoices.search_client');
                $words['bill_to_from'] = trans('invoices.bill_to');
                $words['add_person'] = trans('invoices.add_client');
                $words['m_id'] = 2;
                break;
        }

        return view('focus.orders.edit')->with([
            'orders' => $this->orders])->with(bill_helper(3))->with(['fields_data' => $fields_data,'words'=>$words]);
    }
}