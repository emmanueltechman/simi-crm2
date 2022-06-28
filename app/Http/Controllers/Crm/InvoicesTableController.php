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
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\invoice\InvoiceRepository;
use App\Http\Requests\Focus\invoice\ManageInvoiceRequest;

/**
 * Class InvoicesTableController.
 */
class InvoicesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var InvoiceRepository
     */
    protected $invoice;

    /**
     * contructor to initialize repository object
     * @param InvoiceRepository $invoice ;
     */
    public function __construct(InvoiceRepository $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * This method return the data of the model
     * @param ManageInvoiceRequest $request
     *
     * @return mixed
     */
    public function __invoke()
    {
        //
        $core = $this->invoice->getSelfDataTable(auth('crm')->user()->id);
        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($invoice) {
                $t = token_validator('', 'i' . $invoice->id . $invoice->tid, true);
                $link_preview = route('biller.view_bill', [$invoice->id, 1, $t, 0]);
                return '<a class="font-weight-bold" href="' . $link_preview . '">' . $invoice->tid . '</a>';
            })
            ->addColumn('customer', function ($invoice) {
                return $invoice->customer->name;
            })
            ->addColumn('invoicedate', function ($invoice) {
                return dateFormat($invoice->invoicedate);
            })
            ->addColumn('total', function ($invoice) {
                return amountFormat($invoice->total);
            })
            ->addColumn('status', function ($invoice) {
                return '<span class="st-' . $invoice->status . '">' . trans('payments.' . $invoice->status) . '</span>';
            })
            ->addColumn('invoiceduedate', function ($invoice) {
                return dateFormat($invoice->invoiceduedate);
            })
            ->rawColumns(['tid', 'customer', 'actions', 'status', 'total'])
            ->make(true);
    }
}
