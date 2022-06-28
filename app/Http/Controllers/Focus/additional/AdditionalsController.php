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
namespace App\Http\Controllers\Focus\additional;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\additional\Additional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\additional\CreateResponse;
use App\Http\Responses\Focus\additional\EditResponse;
use App\Repositories\Focus\additional\AdditionalRepository;


/**
 * AdditionalsController
 */
class AdditionalsController extends Controller
{
    /**
     * variable to store the repository object
     * @var AdditionalRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param AdditionalRepository $repository ;
     */
    public function __construct(AdditionalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\additional\ManageAdditionalRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.additionals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateAdditionalRequestNamespace $request
     * @return \App\Http\Responses\Focus\additional\CreateResponse
     */
    public function create(ManageCompanyRequest $request)
    {
        return new CreateResponse('focus.additionals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdditionalRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(ManageCompanyRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.additionals.index'), ['flash_success' => trans('alerts.backend.additionals.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\additional\Additional $additional
     * @param EditAdditionalRequestNamespace $request
     * @return \App\Http\Responses\Focus\additional\EditResponse
     */
    public function edit(Additional $additional, ManageCompanyRequest $request)
    {
        return new EditResponse($additional);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdditionalRequestNamespace $request
     * @param App\Models\additional\Additional $additional
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Additional $additional)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($additional, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.additionals.index'), ['flash_success' => trans('alerts.backend.additionals.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteAdditionalRequestNamespace $request
     * @param App\Models\additional\Additional $additional
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Additional $additional, ManageCompanyRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($additional);
        //returning with successfull message
        return new RedirectResponse(route('biller.additionals.index'), ['flash_success' => trans('alerts.backend.additionals.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteAdditionalRequestNamespace $request
     * @param App\Models\additional\Additional $additional
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Additional $additional, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.additionals.view', compact('additional'));
    }

}
