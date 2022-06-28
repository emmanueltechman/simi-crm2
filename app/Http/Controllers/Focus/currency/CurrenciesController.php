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
namespace App\Http\Controllers\Focus\currency;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\currency\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\currency\CreateResponse;
use App\Http\Responses\Focus\currency\EditResponse;
use App\Repositories\Focus\currency\CurrencyRepository;


/**
 * CurrenciesController
 */
class CurrenciesController extends Controller
{
    /**
     * variable to store the repository object
     * @var CurrencyRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CurrencyRepository $repository ;
     */
    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\currency\ManageCurrencyRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateCurrencyRequestNamespace $request
     * @return \App\Http\Responses\Focus\currency\CreateResponse
     */
    public function create(ManageCompanyRequest $request)
    {
        return new CreateResponse('focus.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCurrencyRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(ManageCompanyRequest $request)
    {
        //Input received from the request
        $request->validate([
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:3',
            'rate' => 'required|numeric|gt:0',
            'thousand_sep' => 'max:1',
            'decimal_sep' => 'max:1',
            'precision_point' => 'required|max:1',
            'symbol_position' => 'required|integer|max:1',
        ]);
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.currencies.index'), ['flash_success' => trans('alerts.backend.currencies.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\currency\Currency $currency
     * @param EditCurrencyRequestNamespace $request
     * @return \App\Http\Responses\Focus\currency\EditResponse
     */
    public function edit(Currency $currency, ManageCompanyRequest $request)
    {
        return new EditResponse($currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCurrencyRequestNamespace $request
     * @param App\Models\currency\Currency $currency
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:3',
            'rate' => 'required|numeric|gt:0',
            'thousand_sep' => 'max:1',
            'decimal_sep' => 'max:1',
            'precision_point' => 'required|max:1',
            'symbol_position' => 'required|integer|max:1',
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($currency, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.currencies.index'), ['flash_success' => trans('alerts.backend.currencies.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCurrencyRequestNamespace $request
     * @param App\Models\currency\Currency $currency
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Currency $currency, ManageCompanyRequest $request)
    {
        //Calling the delete method on repository
        $result = $this->repository->delete($currency);
        //returning with successfull message
        if ($result) return new RedirectResponse(route('biller.currencies.index'), ['flash_success' => trans('alerts.backend.currencies.deleted')]);
        return new RedirectResponse(route('biller.currencies.index'), ['flash_error' => trans('meta.delete_error')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCurrencyRequestNamespace $request
     * @param App\Models\currency\Currency $currency
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Currency $currency, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.currencies.view', compact('currency'));
    }

}
