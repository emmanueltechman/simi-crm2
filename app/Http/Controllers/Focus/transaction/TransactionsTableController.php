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

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\transaction\TransactionRepository;
use App\Http\Requests\Focus\transaction\ManageTransactionRequest;

/**
 * Class TransactionsTableController.
 */
class TransactionsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TransactionRepository
     */
    protected $transaction;

    /**
     * contructor to initialize repository object
     * @param TransactionRepository $transaction ;
     */
    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * This method return the data of the model
     * @param ManageTransactionRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageTransactionRequest $request)
    {
        //
        $core = $this->transaction->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('account_id', function ($transaction) {
                return $transaction->account->holder;
            })
            ->addColumn('trans_category_id', function ($transaction) {

                return '<a class="font-weight-bold" href="' . route('biller.transactions.index') . '?rel_type=0&rel_id=' . $transaction->category['id'] . '">' . $transaction->category['name'] . '</a>';
            })
            ->addColumn('debit', function ($transaction) {
                return amountFormat($transaction->debit);
            })->addColumn('credit', function ($transaction) {
                return amountFormat($transaction->credit);
            })
            ->addColumn('payer', function ($transaction) {

                if ($transaction->payer_id) {
                    switch ($transaction->relation_id) {
                        case 0 :
                            return '<a class="font-weight-bold" href="' . route('biller.transactions.index') . '?rel_type=1&rel_id=' . $transaction->customer['id'] . '">' . $transaction->customer['name'] . '</a>';
                            break;
                        case 3 :
                            return '<a class="font-weight-bold" href="' . route('biller.transactions.index') . '?rel_type=3&rel_id=' . $transaction->employee['id'] . '">' . $transaction->employee['first_name'] . ' ' . $transaction->employee['last_name'] . '</a>';
                            break;
                    }
                }
                if ($transaction->payer) return $transaction->payer;

            })->addColumn('payment_date', function ($transaction) {
                return dateFormat($transaction->payment_date);
            })
            ->addColumn('actions', function ($transaction) {
                return '<a href="' . route('biller.print_payslip', [$transaction['id'], 1, 1]) . '" class="btn btn-blue round" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-print"></i> </a>' . $transaction->action_buttons;
            })
            ->make(true);
    }
}
