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
namespace App\Http\Controllers\Focus\bank;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\bank\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\bank\CreateResponse;
use App\Http\Responses\Focus\bank\EditResponse;
use App\Repositories\Focus\bank\BankRepository;


/**
 * BanksController
 */
class BanksController extends Controller
{
    /**
     * variable to store the repository object
     * @var BankRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param BankRepository $repository ;
     */
    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\bank\ManageBankRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateBankRequestNamespace $request
     * @return \App\Http\Responses\Focus\bank\CreateResponse
     */
    public function create(ManageCompanyRequest $request)
    {
        return new CreateResponse('focus.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBankRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(ManageCompanyRequest $request)
    {
        $request->validate([
            'name' => 'required|string',
            'bank' => 'required|string',
            'number' => 'required'
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.banks.index'), ['flash_success' => trans('alerts.backend.banks.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\bank\Bank $bank
     * @param EditBankRequestNamespace $request
     * @return \App\Http\Responses\Focus\bank\EditResponse
     */
    public function edit(Bank $bank, ManageCompanyRequest $request)
    {
        return new EditResponse($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBankRequestNamespace $request
     * @param App\Models\bank\Bank $bank
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string',
            'bank' => 'required|string',
            'number' => 'required'
        ]);
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($bank, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.banks.index'), ['flash_success' => trans('alerts.backend.banks.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteBankRequestNamespace $request
     * @param App\Models\bank\Bank $bank
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Bank $bank, ManageCompanyRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($bank);
        //returning with successfull message
        return new RedirectResponse(route('biller.banks.index'), ['flash_success' => trans('alerts.backend.banks.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteBankRequestNamespace $request
     * @param App\Models\bank\Bank $bank
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Bank $bank, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.banks.view', compact('bank'));
    }

}
