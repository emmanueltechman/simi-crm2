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
namespace App\Http\Controllers\Focus\transaction;
use App\Models\account\Account;
use App\Models\customer\Customer;
use App\Models\hrm\Hrm;
use App\Models\supplier\Supplier;
use App\Models\transaction\Transaction;
use App\Models\transactioncategory\Transactioncategory;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\transaction\CreateResponse;
use App\Http\Responses\Focus\transaction\EditResponse;
use App\Repositories\Focus\transaction\TransactionRepository;
use App\Http\Requests\Focus\transaction\ManageTransactionRequest;

use App\Http\Requests\Focus\transaction\StoreTransactionRequest;

use Illuminate\Support\Facades\DB;

/**
 * TransactionsController
 */
class TransactionsController extends Controller
{
    /**
     * variable to store the repository object
     * @var TransactionRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TransactionRepository $repository ;
     */
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\transaction\ManageTransactionRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageTransactionRequest $request)
    {

        $input = $request->only('rel_type', 'rel_id');
        $segment = false;
        $words = array();
        if (isset($input['rel_type'])) {
            switch ($input['rel_type']) {
                case 0 :
                    $segment = Transactioncategory::find($input['rel_id']);
                    $words['name'] = trans('transactioncategories.transactioncategory');
                    $words['name_data'] = $segment->name;
                    break;
                case 1 :
                    $segment = Customer::find($input['rel_id']);
                    $words['name'] = trans('customers.title');
                    $words['name_data'] = $segment->name;
                    $words['url'] = '<a href="' . route('biller.customers.show', [$segment['id']]) . '"><i
                                            class="fa fa-user"></i> ' . $segment['name'] . ' </a>';
                    break;
                case 2 :
                    $segment = Hrm::find($input['rel_id']);
                    $words['name'] = trans('hrms.employee');
                    $words['name_data'] = $segment->first_name . ' ' . $segment->last_name;
                    $words['url'] = '<a href="' . route('biller.hrms.show', [$segment['id']]) . '"><i
                                            class="fa fa-user"></i> ' . $words['name_data'] . ' </a>';
                    break;
                case 3 :
                    $segment = Hrm::find($input['rel_id']);
                    $words['name'] = trans('hrms.employee');
                    $words['name_data'] = $segment->first_name . ' ' . $segment->last_name;
                    $words['url'] = '<a href="' . route('biller.hrms.show', [$segment['id']]) . '"><i
                                            class="fa fa-user"></i> ' . $words['name_data'] . ' </a>';
                    break;
                case 4 :
                    $segment = Supplier::find($input['rel_id']);
                    $words['name'] = trans('customers.title');
                    $words['name_data'] = $segment->name;
                    $words['url'] = '<a href="' . route('biller.customers.show', [$segment['id']]) . '"><i
                                            class="fa fa-user"></i> ' . $segment['name'] . ' </a>';
                    break;
                case 9 :
                    $segment = Account::find($input['rel_id']);
                    $words['name'] = trans('accounts.holder');
                    $words['name_data'] = $segment->holder;
                    break;
            }

        }
        return view('focus.transactions.index', compact('input', 'segment', 'words'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateTransactionRequestNamespace $request
     * @return \App\Http\Responses\Focus\transaction\CreateResponse
     */
    public function create(StoreTransactionRequest $request)
    {
        return new CreateResponse('focus.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreTransactionRequest $request)
    {

        //Input received from the request
        $input = $request->except(['_token', 'ins', 'payer_type']);
        $input['ins'] = auth()->user()->ins;
        $input['user_id'] = auth()->user()->id;
        //Create the model using repository create method
        $result = $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.transactions.show', [$result]), ['flash_success' => trans('alerts.backend.transactions.created') . ' <a href="' . route('biller.transactions.show', [$result]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.transactions.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.transactions.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
        // return new RedirectResponse(route('biller.transactions.index'), ['flash_success' => trans('alerts.backend.transactions.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\transaction\Transaction $transaction
     * @param EditTransactionRequestNamespace $request
     * @return \App\Http\Responses\Focus\transaction\EditResponse
     */
    public function edit(Transaction $transaction, StoreTransactionRequest $request)
    {
        return new EditResponse($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransactionRequestNamespace $request
     * @param App\Models\transaction\Transaction $transaction
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($transaction, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.transactions.index'), ['flash_success' => trans('alerts.backend.transactions.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTransactionRequestNamespace $request
     * @param App\Models\transaction\Transaction $transaction
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Transaction $transaction, StoreTransactionRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($transaction);
        //returning with successfull message
        return new RedirectResponse(route('biller.transactions.index'), ['flash_success' => trans('alerts.backend.transactions.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTransactionRequestNamespace $request
     * @param App\Models\transaction\Transaction $transaction
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Transaction $transaction, ManageTransactionRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.transactions.view', compact('transaction'));
    }

    public function payer_search(ManageTransactionRequest $request)
    {
        $q = $request->post('keyword');
        $c = $request->post('payer_type');
        $t = 0;
        switch ($c) {
            case 'customer':
                $user = \App\Models\customer\Customer::with('primary_group')->where('name', 'LIKE', '%' . $q . '%')->where('active', '=', 1)->orWhere('email', 'LIKE', '%' . $q . '')->limit(6)->get(array('id', 'name', 'phone', 'address', 'city', 'email'));
                $t = 1;
                break;
            case 'supplier':
                $user = \App\Models\supplier\Supplier::where('name', 'LIKE', '%' . $q . '%')->where('active', '=', 1)->orWhere('email', 'LIKE', '%' . $q . '')->limit(6)->get(array('id', 'name', 'phone', 'address', 'city', 'email'));
                $t = 2;
                break;
            case 'employee':
                $user = \App\Models\hrm\Hrm::where('first_name', 'LIKE', '%' . $q . '%')->where('status', '=', 1)->orWhere('email', 'LIKE', '%' . $q . '')->select(DB::raw("TRIM(CONCAT(first_name,' - ',last_name)) AS name,id,email"))->limit(6)->get();
                $t = 3;
                break;
            default:
                $user = false;

        }

        if (!$q) return false;
        if (count($user) > 0) return view('focus.transactions.partials.search')->with(compact('user', 't'));

    }


}
