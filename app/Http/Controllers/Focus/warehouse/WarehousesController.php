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
namespace App\Http\Controllers\Focus\warehouse;

use App\Models\warehouse\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\warehouse\CreateResponse;
use App\Http\Responses\Focus\warehouse\EditResponse;
use App\Repositories\Focus\warehouse\WarehouseRepository;
use App\Http\Requests\Focus\warehouse\ManageWarehouseRequest;
use App\Http\Requests\Focus\warehouse\StoreWarehouseRequest;


/**
 * WarehousesController
 */
class WarehousesController extends Controller
{
    /**
     * variable to store the repository object
     * @var WarehouseRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param WarehouseRepository $repository ;
     */
    public function __construct(WarehouseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\warehouse\ManageWarehouseRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageWarehouseRequest $request)
    {
        return new ViewResponse('focus.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateWarehouseRequestNamespace $request
     * @return \App\Http\Responses\Focus\warehouse\CreateResponse
     */
    public function create(StoreWarehouseRequest $request)
    {
        return new CreateResponse('focus.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWarehouseRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreWarehouseRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.warehouses.index'), ['flash_success' => trans('alerts.backend.warehouses.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\warehouse\Warehouse $warehouse
     * @param EditWarehouseRequestNamespace $request
     * @return \App\Http\Responses\Focus\warehouse\EditResponse
     */
    public function edit(Warehouse $warehouse, StoreWarehouseRequest $request)
    {
        return new EditResponse($warehouse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWarehouseRequestNamespace $request
     * @param App\Models\warehouse\Warehouse $warehouse
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreWarehouseRequest $request, Warehouse $warehouse)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($warehouse, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.warehouses.index'), ['flash_success' => trans('alerts.backend.warehouses.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteWarehouseRequestNamespace $request
     * @param App\Models\warehouse\Warehouse $warehouse
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Warehouse $warehouse, StoreWarehouseRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($warehouse);
        //returning with successfull message
        return new RedirectResponse(route('biller.warehouses.index'), ['flash_success' => trans('alerts.backend.warehouses.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteWarehouseRequestNamespace $request
     * @param App\Models\warehouse\Warehouse $warehouse
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Warehouse $warehouse, ManageWarehouseRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.warehouses.view', compact('warehouse'));
    }

}
