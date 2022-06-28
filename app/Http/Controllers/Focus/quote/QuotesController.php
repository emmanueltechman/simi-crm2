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
namespace App\Http\Controllers\Focus\quote;

use App\Http\Requests\Focus\invoice\ManageInvoiceRequest;
use App\Models\quote\Quote;
use App\Repositories\Focus\invoice\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\quote\CreateResponse;
use App\Http\Responses\Focus\quote\EditResponse;
use App\Repositories\Focus\quote\QuoteRepository;
use App\Http\Requests\Focus\quote\ManageQuoteRequest;
use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\customer\Customer;
use App\Models\hrm\Hrm;
use App\Http\Requests\Focus\quote\CreateQuoteRequest;
use App\Http\Requests\Focus\quote\EditQuoteRequest;
use App\Http\Requests\Focus\quote\DeleteQuoteRequest;

/**
 * QuotesController
 */
class QuotesController extends Controller
{
    /**
     * variable to store the repository object
     * @var QuoteRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param QuoteRepository $repository ;
     */
    public function __construct(QuoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\quote\ManageQuoteRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageQuoteRequest $request)
    {
        $input = $request->only('rel_type', 'rel_id');
        $segment = false;
        $words = array();
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

        return new ViewResponse('focus.quotes.index', compact('input', 'segment', 'words'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateQuoteRequestNamespace $request
     * @return \App\Http\Responses\Focus\quote\CreateResponse
     */
    public function create(CreateQuoteRequest $request)
    {
        return new CreateResponse('focus.quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoiceRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateQuoteRequest $request)
    {
        //Input received from the request
        $invoice = $request->only(['customer_id', 'tid', 'refer', 'invoicedate', 'invoiceduedate', 'notes', 'subtotal', 'shipping', 'tax', 'discount', 'discount_rate', 'after_disc', 'currency', 'total', 'tax_format', 'discount_format', 'ship_tax', 'ship_tax_type', 'ship_rate', 'ship_tax', 'term_id', 'tax_id','proposal']);
        $invoice_items = $request->only(['product_id', 'product_name', 'code', 'product_qty', 'product_price', 'product_tax', 'product_discount', 'product_subtotal', 'product_subtotal', 'total_tax', 'total_discount', 'product_description', 'unit']);
        $data2 = $request->only(['custom_field']);
        $data2['ins'] = auth()->user()->ins;
        //dd($invoice_items);
        $invoice['ins'] = auth()->user()->ins;
        $invoice['user_id'] = auth()->user()->id;
        $invoice_items['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $result = $this->repository->create(compact('invoice', 'invoice_items', 'data2'));
        //return with successfull message

        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.quotes.created') . ' <a href="' . route('biller.quotes.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\quote\Quote $quote
     * @param EditQuoteRequestNamespace $request
     * @return \App\Http\Responses\Focus\quote\EditResponse
     */
    public function edit(Quote $quote, EditQuoteRequest $request)
    {
        return new EditResponse($quote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuoteRequestNamespace $request
     * @param App\Models\quote\Quote $quote
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditQuoteRequest $request, Quote $quote)
    {

        //Input received from the request
        $invoice = $request->only(['customer_id', 'id', 'refer', 'invoicedate', 'invoiceduedate', 'notes', 'subtotal', 'shipping', 'tax', 'discount', 'discount_rate', 'after_disc', 'currency', 'total', 'tax_format', 'discount_format', 'ship_tax', 'ship_tax_type', 'ship_rate', 'ship_tax', 'term_id', 'tax_id', 'restock','proposal']);
        $invoice_items = $request->only(['product_id', 'product_name', 'code', 'product_qty', 'product_price', 'product_tax', 'product_discount', 'product_subtotal', 'product_subtotal', 'total_tax', 'total_discount', 'product_description', 'unit', 'old_product_qty']);
        //dd($request->id);
        $invoice['ins'] = auth()->user()->ins;
        //$invoice['user_id']=auth()->user()->id;
        $invoice_items['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $data2 = $request->only(['custom_field']);
        $data2['ins'] = auth()->user()->ins;


        $result = $this->repository->update($quote, compact('invoice', 'invoice_items', 'data2'));

        //return with successfull message

        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.quotes.updated') . ' <a href="' . route('biller.quotes.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteQuoteRequestNamespace $request
     * @param App\Models\quote\Quote $quote
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Quote $quote, DeleteQuoteRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($quote);
        //returning with successfull message
        return new RedirectResponse(route('biller.quotes.index'), ['flash_success' => trans('alerts.backend.quotes.deleted')]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteQuoteRequestNamespace $request
     * @param App\Models\quote\Quote $quote
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Quote $quote, ManageQuoteRequest $request)
    {

        $accounts = Account::all();
        $features = ConfigMeta::where('feature_id', 9)->first();

        //returning with successfull message
        $quote['bill_type'] = 4;
        $terms = \App\Models\term\Term::where('type', 0)->orWhere('type', 1)->get();
        return new ViewResponse('focus.quotes.view', compact('quote', 'accounts', 'features','terms'));
    }




    public function convert(InvoiceRepository $invoicerepository, ManageInvoiceRequest $request)
    {
        $input = $request->only(['bill_id', 'delete_item','term_id','assign_self']);

        $quote_o = Quote::where('id', '=', $input['bill_id'])->first();
        if($input['term_id'])$quote_o['term_id']=$input['term_id'];
        //Input received from the request
         $status=feature(10)['value2'];
        $input['invoice'] = array_map('strip_tags', $input['invoice']);
        $invoice = array('customer_id' => $quote_o['customer_id'], 'tid' => $quote_o['tid'], 'refer' => $quote_o['refer'], 'invoicedate' => $quote_o['invoicedate'], 'invoiceduedate' => $quote_o['invoiceduedate'], 'notes' => $quote_o['notes'], 'subtotal' => $quote_o['subtotal'], 'shipping' => $quote_o['shipping'], 'tax' => $quote_o['tax'], 'discount' => $quote_o['discount'], 'discount_rate' => $quote_o['discount_rate'], 'after_disc' => $quote_o['after_disc'], 'total' => $quote_o['total'], 'tax_format' => $quote_o['tax_format'], 'discount_format' => $quote_o['discount_format'], 'ship_tax' => $quote_o['ship_tax'], 'ship_tax_type' => $quote_o['ship_tax_type'], 'ship_rate' => $quote_o['ship_rate'], 'term_id' => $quote_o['term_id'], 'tax_id' => $quote_o['tax_id'],'user_id'=> $quote_o['user_id']);
         if($status) $invoice['status']=$status;
        $invoice_items = $quote_o->products;
        //$data2 = $request->only(['custom_field']);
        $data2['ins'] = auth()->user()->ins;
        //dd($invoice_items);
        $invoice['ins'] = auth()->user()->ins;

        if($input['assign_self'] && access()->allow('business_settings')) $invoice['user_id'] = auth()->user()->id;

        //Create the model using repository create method
        $result = $invoicerepository->convert(compact('invoice', 'invoice_items', 'data2'));

        if ($input['bill_id'] == @$input['delete_item']) {
            $quote_o->delete();
        } else {
            $quote_o->status = 'approved';
            $quote_o->save();
        }

        //return with successfull message
        //return new RedirectResponse(route('biller.invoices.index'), ['flash_success' => trans('alerts.backend.invoices.created')]);
        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.invoices.created') . ' <a href="' . route('biller.invoices.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;'));

    }

    public function update_status(ManageQuoteRequest $request)
    {

        $input = $request->only(['bill_id', 'status']);
        $quote_o = Quote::where('id', '=', $input['bill_id'])->first();
        if ($quote_o->id) {
            $quote_o->status = $input['status'];
            $quote_o->save();
        }
        //return with successfull message
        echo json_encode(array('status' => 'Success', 'message' => trans('general.bill_status_update'), 'bill_status' => trans('payments.' . $input['status'])));

    }

}
