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
namespace App\Http\Controllers\Focus\prefix;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\prefix\Prefix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\prefix\EditResponse;
use App\Repositories\Focus\prefix\PrefixRepository;


/**
 * PrefixesController
 */
class PrefixesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PrefixRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PrefixRepository $repository ;
     */
    public function __construct(PrefixRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\prefix\ManagePrefixRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.prefixes.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\prefix\Prefix $prefix
     * @param EditPrefixRequestNamespace $request
     * @return \App\Http\Responses\Focus\prefix\EditResponse
     */
    public function edit(Prefix $prefix, ManageCompanyRequest $request)
    {
        return new EditResponse($prefix);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePrefixRequestNamespace $request
     * @param App\Models\prefix\Prefix $prefix
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Prefix $prefix)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($prefix, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.prefixes.index'), ['flash_success' => trans('alerts.backend.prefixes.updated')]);
    }


}
