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
namespace App\Http\Controllers\Focus\customergroup;

use App\Models\customergroup\Customergroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\customergroup\CreateResponse;
use App\Http\Responses\Focus\customergroup\EditResponse;
use App\Repositories\Focus\customergroup\CustomergroupRepository;
use App\Http\Requests\Focus\customergroup\ManageCustomergroupRequest;
use App\Http\Requests\Focus\customergroup\CreateCustomergroupRequest;
use App\Http\Requests\Focus\customergroup\EditCustomergroupRequest;
use App\Http\Requests\Focus\customergroup\DeleteCustomergroupRequest;

/**
 * CustomergroupsController
 */
class CustomergroupsController extends Controller
{
    /**
     * variable to store the repository object
     * @var CustomergroupRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CustomergroupRepository $repository ;
     */
    public function __construct(CustomergroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\customergroup\ManageCustomergroupRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCustomergroupRequest $request)
    {
        return new ViewResponse('focus.customergroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateCustomergroupRequestNamespace $request
     * @return \App\Http\Responses\Backend\customergroup\CreateResponse
     */
    public function create(CreateCustomergroupRequest $request)
    {
        return new CreateResponse('focus.customergroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCustomergroupRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateCustomergroupRequest $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $id = $this->repository->create($input);
        //return with successfull message

        return new RedirectResponse(route('biller.customergroups.show', [$id]), ['flash_success' => trans('alerts.backend.customergroups.created') . ' <a href="' . route('biller.customergroups.show', [$id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.customergroups.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.customergroups.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\customergroup\Customergroup $customergroup
     * @param EditCustomergroupRequestNamespace $request
     * @return \App\Http\Responses\Backend\customergroup\EditResponse
     */
    public function edit(Customergroup $customergroup, EditCustomergroupRequest $request)
    {
        return new EditResponse($customergroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomergroupRequestNamespace $request
     * @param App\Models\customergroup\Customergroup $customergroup
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditCustomergroupRequest $request, Customergroup $customergroup)
    {
        $request->validate([
            'title' => 'required'
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($customergroup, $input);
        //return with successfull message

        return new RedirectResponse(route('biller.customergroups.show', [$customergroup->id]), ['flash_success' => trans('alerts.backend.customergroups.updated') . ' <a href="' . route('biller.customergroups.show', [$customergroup->id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.customergroups.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.customergroups.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCustomergroupRequestNamespace $request
     * @param App\Models\customergroup\Customergroup $customergroup
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Customergroup $customergroup, DeleteCustomergroupRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($customergroup);
        //returning with successfull message
        return new RedirectResponse(route('biller.customergroups.index'), ['flash_success' => trans('alerts.backend.customergroups.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCustomergroupRequestNamespace $request
     * @param App\Models\customergroup\Customergroup $customergroup
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Customergroup $customergroup, ManageCustomergroupRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.customergroups.view', compact('customergroup'));
    }

}
