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

namespace App\Http\Controllers\Focus\supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\purchaseorder\CreatePurchaseorderRequest;
use App\Http\Requests\Focus\supplier\CreateSupplierRequest;
use App\Http\Requests\Focus\supplier\DeleteSupplierRequest;
use App\Http\Requests\Focus\supplier\EditSupplierRequest;
use App\Http\Requests\Focus\supplier\ManageSupplierRequest;
use App\Http\Requests\Focus\supplier\StoreSupplierRequest;
use App\Http\Requests\Focus\supplier\UpdateSupplierRequest;
use App\Http\Requests\Request;
use App\Http\Responses\Focus\supplier\CreateResponse;
use App\Http\Responses\Focus\supplier\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\supplier\Supplier;
use App\Repositories\Focus\supplier\SupplierRepository;

/**
 * SuppliersController
 */
class SuppliersController extends Controller
{
    /**
     * variable to store the repository object
     * @var SupplierRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param SupplierRepository $repository ;
     */
    public function __construct(SupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\supplier\ManageSupplierRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageSupplierRequest $request)
    {
        return new ViewResponse('focus.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateSupplierRequestNamespace $request
     * @return \App\Http\Responses\Focus\supplier\CreateResponse
     */
    public function create(StoreSupplierRequest $request)
    {
        return new CreateResponse('focus.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplierRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreSupplierRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        if (!empty($input['picture'])) {
            $request->validate([
                'picture' => 'mimes:jpeg,png',
            ]);
        }
        $result = $this->repository->create($input);
        //return with successfull message
        if ($request->ajax()) {
            $result['random_password'] = null;
            echo json_encode($result);
        } else {
            return new RedirectResponse(route('biller.suppliers.index'), ['flash_success' => trans('alerts.backend.suppliers.created')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\supplier\Supplier $supplier
     * @param EditSupplierRequestNamespace $request
     * @return \App\Http\Responses\Focus\supplier\EditResponse
     */
    public function edit(Supplier $supplier, StoreSupplierRequest $request)
    {
        return new EditResponse($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplierRequestNamespace $request
     * @param App\Models\supplier\Supplier $supplier
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreSupplierRequest $request, Supplier $supplier)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        if (!empty($input['picture'])) {
            $request->validate([
                'picture' => 'mimes:jpeg,png',
            ]);
        }
        $this->repository->update($supplier, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.suppliers.index'), ['flash_success' => trans('alerts.backend.suppliers.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteSupplierRequestNamespace $request
     * @param App\Models\supplier\Supplier $supplier
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Supplier $supplier, StoreSupplierRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($supplier);
        //returning with successfull message
        return new RedirectResponse(route('biller.suppliers.index'), ['flash_success' => trans('alerts.backend.suppliers.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteSupplierRequestNamespace $request
     * @param App\Models\supplier\Supplier $supplier
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Supplier $supplier, ManageSupplierRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.suppliers.view', compact('supplier'));
    }

    public function search(CreatePurchaseorderRequest $request)
    {

        $q = $request->post('keyword');
        $user = Supplier::where('name', 'LIKE', '%' . $q . '%')->where('active', '=', 1)->orWhere('email', 'LIKE', '%' . $q . '')->orWhere('company', 'LIKE', '%' . $q . '')->limit(6)->get(array('id', 'name', 'phone', 'address', 'city', 'email'));
        if (count($user) > 0) return view('focus.suppliers.partials.search')->with(compact('user'));
    }

    public function select(ManageSupplierRequest $request)
    {

        $q = $request->post('person');
        $user = Supplier::where('name', 'LIKE', '%' . @$q['term'] . '%')->where('active', '=', 1)->orWhere('email', 'LIKE', '%' . @$q['term'] . '')->limit(6)->get(array('id', 'name', 'phone', 'address', 'city', 'email'));
        if (count($user) > 0) return json_encode($user);
    }

    public function active(ManageSupplierRequest $request)
    {

        $cid = $request->post('cid');
        $active = $request->post('active');
        $active = !(bool)$active;
        Supplier::where('id', '=', $cid)->update(array('active' => $active));
    }

}
