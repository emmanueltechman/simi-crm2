<?php

namespace App\Http\Responses\Focus\order;

use App\Models\order\Order;
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

        switch ($request->section) {
            case 'creditnote':
                $last_invoice = Order::orderBy('id', 'desc')->where('i_class', '=', 2)->first();
                $words['title'] = trans('orders.credit_notes_manage');
                $words['prefix'] = prefix(7);
                $words['properties'] = trans('orders.credit_notes_properties');
                $words['person_details'] = trans('invoices.client_details');
                $words['enter_person'] = trans('invoices.enter_customer');
                $words['search_person'] = trans('invoices.search_client');
                $words['bill_to_from'] = trans('invoices.bill_to');
                $words['add_person'] = trans('invoices.add_client');
                $words['m_id'] = 2;
                $words['section_person'] ='customer';
                break;
                 case 'stockreturn':
                     if (access()->allow('stockreturn-data')) {
                         $last_invoice = Order::orderBy('id', 'desc')->where('i_class', '=', 3)->first();
                         $words['title'] = trans('orders.credit_notes_manage');
                         $words['prefix'] = prefix(8);
                         $words['properties'] = trans('orders.stock_return_properties');
                         $words['person_details'] = trans('purchaseorders.supplier_details');
                         $words['enter_person'] = trans('purchaseorders.supplier_search');
                         $words['search_person'] = trans('purchaseorders.search_supplier');
                         $words['bill_to_from'] = trans('purchaseorders.bill_from');
                         $words['add_person'] = trans('purchaseorders.add_supplier');
                         $words['m_id'] = 3;
                         $words['section_person'] = 'suppliers';
                     } else {
                         exit();
                     }
                break;
        }
        return view('focus.orders.create')->with(array('last_invoice' => $last_invoice, 'words' => $words))->with(bill_helper(3, 5));
    }
}