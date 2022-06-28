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
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\quote\Quote;
use App\Repositories\Focus\quote\QuoteRepository;
use App\Http\Requests\Focus\quote\ManageQuoteRequest;
use App\Models\customer\Customer;
use App\Models\hrm\Hrm;
use Illuminate\Http\Request;


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
    public function index(Request $request)
    {
        $input = $request->only('rel_type', 'rel_id');
        $segment = false;
        $words = array();
        return new ViewResponse('crm.quotes.index', compact('input', 'segment', 'words'));
    }

    public function approve(Request $request)
    {
        $quote = Quote::withoutGlobalScopes()->find($request->id);
        if ($quote->customer_id == auth('crm')->user()->id) {
            $quote->status = 'customer_approved';
            $quote->save();
        }

        return new RedirectResponse(route('crm.quotes.index'), ['flash_success' => trans('customers.logout_success')]);
    }


}
