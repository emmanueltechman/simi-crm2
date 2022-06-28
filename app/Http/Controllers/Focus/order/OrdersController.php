<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\order;

use App\Models\order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\order\CreateResponse;
use App\Http\Responses\Focus\order\EditResponse;
use App\Repositories\Focus\order\OrderRepository;

//Ported
use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\customer\Customer;
use App\Models\hrm\Hrm;
use App\Http\Requests\Focus\order\StoreOrderRequest;


/**
 * OrdersController
 */
class OrdersController extends Controller
{
    /**
     * variable to store the repository object
     * @var OrderRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param OrderRepository $repository ;
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\order\ManageOrderRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(StoreOrderRequest $request)
    {
        $input = $request->only('rel_type', 'rel_id', 'section');
        $segment = false;
        $words = array();
        $words['person'] = trans('customers.customer');
        if (isset($input['rel_id']) and isset($input['rel_type'])) {
            switch ($input['rel_type']) {
                case 1 :
                    $segment = Customer::find($input['rel_id']);
                    $words['name'] = trans('customers.title');
                    $words['name_data'] = $segment->name;
                    break;
                case 2 :
                    $segment = Hrm::find($input['rel_id']);
                    $words['name'] = trans('hrms.employee');
                    $words['name_data'] = $segment->first_name . ' ' . $segment->last_name;
                    break;

            }
        }

        if (isset($input['section'])) {
            switch ($input['section']) {
                case 'creditnote' :
                    if (!access()->allow('creditnote-manage')) exit();
                    $words['title'] = trans('orders.credit_notes_manage');
                    $words['prefix'] = prefix(7);
                    $words['section'] = 'creditnote';
                    $words['section_url'] = '?section=creditnote';
                    break;
                case 'stockreturn' :
                    if (!access()->allow('stockreturn-manage')) exit();
                    $words['title'] = trans('orders.stock_return_manage');
                    $words['prefix'] = prefix(8);
                    $words['section'] = 'stockreturn';
                    $words['section_url'] = '?section=stockreturn';
                    $words['person'] = trans('suppliers.suppliers');

                    break;
            }
        } else {
            exit;
        }

        return new ViewResponse('focus.orders.index', compact('input', 'segment', 'words'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateOrderRequestNamespace $request
     * @return \App\Http\Responses\Focus\order\CreateResponse
     */
    public function create(StoreOrderRequest $request)
    {
        return new CreateResponse('focus.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoiceRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreOrderRequest $request)
    {
        //Input received from the request
        $invoice = $request->only(['customer_id', 'tid', 'refer', 'invoicedate', 'invoiceduedate', 'notes', 'subtotal', 'shipping', 'tax', 'discount', 'discount_rate', 'after_disc', 'currency', 'total', 'tax_format', 'discount_format', 'ship_tax', 'ship_tax_type', 'ship_rate', 'ship_tax', 'term_id', 'tax_id', 'type_bill']);
        $invoice_items = $request->only(['product_id', 'product_name', 'code', 'product_qty', 'product_price', 'product_tax', 'product_discount', 'product_subtotal', 'product_subtotal', 'total_tax', 'total_discount', 'product_description', 'unit']);
        $data2 = $request->only(['custom_field']);
        $data2['ins'] = auth()->user()->ins;
        //dd($invoice_items);
        $invoice['ins'] = auth()->user()->ins;
        $invoice['user_id'] = auth()->user()->id;
        $invoice_items['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        if ($invoice['type_bill'] < 2) exit();
        if ($invoice['type_bill'] == 3 and !access()->allow('stockreturn-data')) exit();
        if ($invoice['type_bill'] == 2 and !access()->allow('data-creditnote')) exit();

        $result = $this->repository->create(compact('invoice', 'invoice_items', 'data2'));
        //return with successfull message

        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.orders.created') . ' <a href="' . route('biller.orders.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\order\Order $order
     * @param EditOrderRequestNamespace $request
     * @return \App\Http\Responses\Focus\order\EditResponse
     */
    public function edit(Order $order, StoreOrderRequest $request)
    {
        return new EditResponse($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequestNamespace $request
     * @param App\Models\order\Order $order
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreOrderRequest $request, Order $order)
    {


        //Input received from the request
        $invoice = $request->only(['customer_id', 'id', 'refer', 'invoicedate', 'invoiceduedate', 'notes', 'subtotal', 'shipping', 'tax', 'discount', 'discount_rate', 'after_disc', 'currency', 'total', 'tax_format', 'discount_format', 'ship_tax', 'ship_tax_type', 'ship_rate', 'ship_tax', 'term_id', 'tax_id', 'restock']);
        $invoice_items = $request->only(['product_id', 'product_name', 'code', 'product_qty', 'product_price', 'product_tax', 'product_discount', 'product_subtotal', 'product_subtotal', 'total_tax', 'total_discount', 'product_description', 'unit', 'old_product_qty']);
        //dd($request->id);
        $invoice['ins'] = auth()->user()->ins;
        //$invoice['user_id']=auth()->user()->id;
        $invoice_items['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $data2 = $request->only(['custom_field']);
        $data2['ins'] = auth()->user()->ins;

        if ($order->i_class == 3 and !access()->allow('stockreturn-data')) exit();
        if ($order->i_class == 2 and !access()->allow('data-creditnote')) exit();


        $result = $this->repository->update($order, compact('invoice', 'invoice_items', 'data2'));

        //return with successfull message

        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.orders.updated') . ' <a href="' . route('biller.orders.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteOrderRequestNamespace $request
     * @param App\Models\order\Order $order
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Order $order, StoreOrderRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($order);
        //returning with successfull message
        return json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.orders.deleted')));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteOrderRequestNamespace $request
     * @param App\Models\order\Order $order
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Order $order, StoreOrderRequest $request)
    {

        $accounts = Account::all();
        $features = ConfigMeta::where('feature_id', 9)->first();

        switch ($order->i_class) {
            case 2:
                if (!access()->allow('creditnote-manage')) exit();
                $words['title'] = trans('orders.credit_note');
                $words['prefix'] = prefix(7);
                $words['properties'] = trans('orders.credit_notes_properties');
                $words['person_details'] = trans('invoices.client_details');
                $words['enter_person'] = trans('invoices.enter_customer');
                $words['search_person'] = trans('invoices.search_client');
                $words['bill_to_from'] = trans('invoices.bill_to');
                $words['add_person'] = trans('invoices.add_client');
                $words['m_id'] = 2;
                $words['pay_note'] = trans('orders.credit_note_refund') . ' ' . $words['prefix'] . ' ' . $order->tid;
                break;
            case 3:
                if (!access()->allow('stockreturn-manage')) exit();
                $words['title'] = trans('orders.stock_return');
                $words['prefix'] = prefix(8);
                $words['properties'] = trans('orders.stock_return_properties');
                $words['person_details'] = trans('purchaseorders.supplier_details');
                $words['enter_person'] = trans('purchaseorders.supplier_search');
                $words['search_person'] = trans('purchaseorders.search_supplier');
                $words['bill_to_from'] = trans('purchaseorders.bill_from');
                $words['add_person'] = trans('purchaseorders.add_supplier');
                $words['m_id'] = 2;
                $words['pay_note'] = trans('orders.stock_return_refund') . ' ' . $words['prefix'] . ' ' . $order->tid;

                break;
            default:
                exit();
        }

        //returning with successfull message
        $order['bill_type'] = 1;
        return new ViewResponse('focus.orders.view', compact('order', 'accounts', 'features', 'words'));
    }


}
