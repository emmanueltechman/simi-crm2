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
use Illuminate\Http\Request;
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
    public function __invoke(Request $request)
    {


        $core = $this->quote->getSelfDataTable(auth('crm')->user()->id);
        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($quote) {
                $t = token_validator('', 'q' . $quote->id . $quote->tid, true);
                $link_preview = route('biller.view_bill', [$quote->id, 4, $t, 0]);
                return '<a class="font-weight-bold" href="' . $link_preview . '">' . $quote->tid . '</a>';
            })
            ->addColumn('customer', function ($quote) {
                return $quote->customer->name;
            })
            ->addColumn('created_at', function ($quote) {
                return dateFormat($quote->invoicedate);
            })
            ->addColumn('total', function ($quote) {
                return amountFormat($quote->total);
            })
            ->addColumn('status', function ($quote) {
                if ($quote->status == 'pending') {
                    return '<span onclick="approve(' . $quote->id . ')" class=" st-due" data-object-id="' . $quote->id . '">' . trans('payments.approve') . '</span>';
                }
                return '<span class="st-' . $quote->status . '">' . trans('payments.' . $quote->status) . '</span>';
            })
            ->addColumn('actions', function ($quote) {
                return $quote->action_buttons;
            })->rawColumns(['tid', 'customer', 'actions', 'status', 'total'])
            ->make(true);
    }
}
