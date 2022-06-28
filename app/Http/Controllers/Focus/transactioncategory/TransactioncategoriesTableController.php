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
namespace App\Http\Controllers\Focus\transactioncategory;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\transactioncategory\TransactioncategoryRepository;
use App\Http\Requests\Focus\transactioncategory\ManageTransactioncategoryRequest;

/**
 * Class TransactioncategoriesTableController.
 */
class TransactioncategoriesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TransactioncategoryRepository
     */
    protected $transactioncategory;

    /**
     * contructor to initialize repository object
     * @param TransactioncategoryRepository $transactioncategory ;
     */
    public function __construct(TransactioncategoryRepository $transactioncategory)
    {
        $this->transactioncategory = $transactioncategory;
    }

    /**
     * This method return the data of the model
     * @param ManageTransactioncategoryRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->transactioncategory->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('created_at', function ($transactioncategory) {
                return Carbon::parse($transactioncategory->created_at)->toDateString();
            })
            ->addColumn('actions', function ($transactioncategory) {
                return $transactioncategory->action_buttons;
            })
            ->make(true);
    }
}
