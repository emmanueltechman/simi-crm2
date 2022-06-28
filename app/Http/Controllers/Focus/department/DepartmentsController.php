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
namespace App\Http\Controllers\Focus\department;

use App\Models\department\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\department\CreateResponse;
use App\Http\Responses\Focus\department\EditResponse;
use App\Repositories\Focus\department\DepartmentRepository;
use App\Http\Requests\Focus\department\ManageDepartmentRequest;
use App\Http\Requests\Focus\department\StoreDepartmentRequest;


/**
 * DepartmentsController
 */
class DepartmentsController extends Controller
{
    /**
     * variable to store the repository object
     * @var DepartmentRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param DepartmentRepository $repository ;
     */
    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\department\ManageDepartmentRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageDepartmentRequest $request)
    {
        return new ViewResponse('focus.departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateDepartmentRequestNamespace $request
     * @return \App\Http\Responses\Focus\department\CreateResponse
     */
    public function create(StoreDepartmentRequest $request)
    {
        return new CreateResponse('focus.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepartmentRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreDepartmentRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.departments.index'), ['flash_success' => trans('alerts.backend.departments.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\department\Department $department
     * @param EditDepartmentRequestNamespace $request
     * @return \App\Http\Responses\Focus\department\EditResponse
     */
    public function edit(Department $department, StoreDepartmentRequest $request)
    {
        return new EditResponse($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDepartmentRequestNamespace $request
     * @param App\Models\department\Department $department
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreDepartmentRequest $request, Department $department)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($department, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.departments.index'), ['flash_success' => trans('alerts.backend.departments.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteDepartmentRequestNamespace $request
     * @param App\Models\department\Department $department
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Department $department, StoreDepartmentRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($department);
        //returning with successfull message
        return new RedirectResponse(route('biller.departments.index'), ['flash_success' => trans('alerts.backend.departments.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteDepartmentRequestNamespace $request
     * @param App\Models\department\Department $department
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Department $department, ManageDepartmentRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.departments.view', compact('department'));
    }

}
