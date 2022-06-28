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

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\quote\QuoteRepository;
use App\Http\Requests\Focus\quote\ManageQuoteRequest;

/**
 * Class QuotesTableController.
 */
class QuotesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var QuoteRepository
     */
    protected $quote;

    /**
     * contructor to initialize repository object
     * @param QuoteRepository $quote ;
     */
    public function __construct(QuoteRepository $quote)
    {
        $this->quote = $quote;
    }

    /**
     * This method return the data of the model
     * @param ManageQuoteRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageQuoteRequest $request)
    {


        $core = $this->quote->getForDataTable();
        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($quote) {
                return '<a class="font-weight-bold" href="' . route('biller.quotes.show', [$quote->id]) . '">' . $quote->tid . '</a>';
            })
            ->addColumn('customer', function ($quote) {
               if(isset($quote->customer)) return $quote->customer->name . ' <a class="font-weight-bold" href="' . route('biller.customers.show', [$quote->customer->id]) . '"><i class="ft-eye"></i></a>';
               return null;
            })
            ->addColumn('created_at', function ($quote) {
                return dateFormat($quote->invoicedate);
            })
            ->addColumn('total', function ($quote) {
                return amountFormat($quote->total);
            })
            ->addColumn('status', function ($quote) {
                return '<span class="st-' . $quote->status . '">' . trans('payments.' . $quote->status) . '</span>';
            })
            ->addColumn('actions', function ($quote) {
                return $quote->action_buttons;
            })->rawColumns(['tid', 'customer', 'actions', 'status', 'total'])
            ->make(true);
    }
}
