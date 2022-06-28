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
namespace App\Http\Controllers\Focus\productcategory;

use App\Models\productcategory\Productcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\productcategory\CreateResponse;
use App\Http\Responses\Focus\productcategory\EditResponse;
use App\Repositories\Focus\productcategory\ProductcategoryRepository;
use App\Http\Requests\Focus\productcategory\ManageProductcategoryRequest;
use App\Http\Requests\Focus\productcategory\StoreProductcategoryRequest;


/**
 * ProductcategoriesController
 */
class ProductcategoriesController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProductcategoryRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProductcategoryRepository $repository ;
     */
    public function __construct(ProductcategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\productcategory\ManageProductcategoryRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageProductcategoryRequest $request)
    {
        return new ViewResponse('focus.productcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateProductcategoryRequestNamespace $request
     * @return \App\Http\Responses\Focus\productcategory\CreateResponse
     */
    public function create(StoreProductcategoryRequest $request)
    {
        return new CreateResponse('focus.productcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductcategoryRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreProductcategoryRequest $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
         if ($input['rel_id'] == 0) $input['c_type'] = 0;
        if ($input['c_type'] == 0) $input['rel_id'] = 0;
        $id = $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.productcategories.index'), ['flash_success' => trans('alerts.backend.productcategories.created') . ' <a href="' . route('biller.productcategories.show', [$id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.productcategories.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.productcategories.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\productcategory\Productcategory $productcategory
     * @param EditProductcategoryRequestNamespace $request
     * @return \App\Http\Responses\Focus\productcategory\EditResponse
     */
    public function edit(Productcategory $productcategory, StoreProductcategoryRequest $request)
    {
        return new EditResponse($productcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductcategoryRequestNamespace $request
     * @param App\Models\productcategory\Productcategory $productcategory
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreProductcategoryRequest $request, Productcategory $productcategory)
    {
        $request->validate([
            'title' => 'required'
        ]);
        //Input received from the request
        $input = $request->only(['title', 'extra']);
        //Update the model using repository update method
        $this->repository->update($productcategory, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.productcategories.index'), ['flash_success' => trans('alerts.backend.productcategories.updated') . ' <a href="' . route('biller.productcategories.show', [$productcategory->id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.productcategories.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.productcategories.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProductcategoryRequestNamespace $request
     * @param App\Models\productcategory\Productcategory $productcategory
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Productcategory $productcategory, StoreProductcategoryRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($productcategory);
        //returning with successfull message
        return new RedirectResponse(route('biller.productcategories.index'), ['flash_success' => trans('alerts.backend.productcategories.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProductcategoryRequestNamespace $request
     * @param App\Models\productcategory\Productcategory $productcategory
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Productcategory $productcategory, ManageProductcategoryRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.productcategories.view', compact('productcategory'));
    }

}
