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
namespace App\Http\Controllers\Focus\gateway;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\Gateway\Usergatewayentry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\gateway\CreateResponse;
use App\Http\Responses\Focus\gateway\EditResponse;
use App\Repositories\Focus\gateway\UsergatewayentryRepository;

/**
 * UsergatewayentriesController
 */
class UsergatewayentriesController extends Controller
{
    /**
     * variable to store the repository object
     * @var UsergatewayentryRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param UsergatewayentryRepository $repository ;
     */
    public function __construct(UsergatewayentryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\gateway\ManageUsergatewayentryRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.gateways.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateUsergatewayentryRequestNamespace $request
     * @return \App\Http\Responses\Focus\gateway\CreateResponse
     */
    public function create(ManageCompanyRequest $request)
    {
        return new CreateResponse('focus.gateways.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUsergatewayentryRequestNamespace $request
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
        return new RedirectResponse(route('biller.usergatewayentries.index'), ['flash_success' => trans('alerts.backend.usergatewayentries.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\gateway\Usergatewayentry $usergatewayentry
     * @param EditUsergatewayentryRequestNamespace $request
     * @return \App\Http\Responses\Focus\gateway\EditResponse
     */
    public function edit(Usergatewayentry $usergatewayentry, ManageCompanyRequest $request)
    {
        return new EditResponse($usergatewayentry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUsergatewayentryRequestNamespace $request
     * @param App\Models\gateway\Usergatewayentry $usergatewayentry
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Usergatewayentry $usergatewayentry)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($usergatewayentry, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.usergatewayentries.index'), ['flash_success' => trans('alerts.backend.usergatewayentries.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUsergatewayentryRequestNamespace $request
     * @param App\Models\gateway\Usergatewayentry $usergatewayentry
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Usergatewayentry $usergatewayentry, ManageCompanyRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($usergatewayentry);
        //returning with successfull message
        return new RedirectResponse(route('biller.usergatewayentries.index'), ['flash_success' => trans('alerts.backend.usergatewayentries.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUsergatewayentryRequestNamespace $request
     * @param App\Models\gateway\Usergatewayentry $usergatewayentry
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Usergatewayentry $usergatewayentry, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.gateways.view', compact('usergatewayentry'));
    }

}
