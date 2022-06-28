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
namespace App\Http\Controllers\Focus\customfield;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\customfield\Customfield;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\customfield\CreateResponse;
use App\Http\Responses\Focus\customfield\EditResponse;
use App\Repositories\Focus\customfield\CustomfieldRepository;

/**
 * CustomfieldsController
 */
class CustomfieldsController extends Controller
{
    /**
     * variable to store the repository object
     * @var CustomfieldRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CustomfieldRepository $repository ;
     */
    public function __construct(CustomfieldRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\customfield\ManageCustomfieldRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.customfields.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateCustomfieldRequestNamespace $request
     * @return \App\Http\Responses\Focus\customfield\CreateResponse
     */
    public function create(ManageCompanyRequest $request)
    {
        return new CreateResponse('focus.customfields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCustomfieldRequestNamespace $request
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
        return new RedirectResponse(route('biller.customfields.index'), ['flash_success' => trans('alerts.backend.customfields.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\customfield\Customfield $customfield
     * @param EditCustomfieldRequestNamespace $request
     * @return \App\Http\Responses\Focus\customfield\EditResponse
     */
    public function edit(Customfield $customfield, ManageCompanyRequest $request)
    {
        return new EditResponse($customfield);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomfieldRequestNamespace $request
     * @param App\Models\customfield\Customfield $customfield
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Customfield $customfield)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($customfield, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.customfields.index'), ['flash_success' => trans('alerts.backend.customfields.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCustomfieldRequestNamespace $request
     * @param App\Models\customfield\Customfield $customfield
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Customfield $customfield, ManageCompanyRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($customfield);
        //returning with successfull message
        return new RedirectResponse(route('biller.customfields.index'), ['flash_success' => trans('alerts.backend.customfields.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCustomfieldRequestNamespace $request
     * @param App\Models\customfield\Customfield $customfield
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Customfield $customfield, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.customfields.view', compact('customfield'));
    }

}
