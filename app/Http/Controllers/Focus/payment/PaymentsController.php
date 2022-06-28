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

namespace App\Http\Controllers\Focus\payment;

use App\Http\Requests\Focus\payment\MakePaymentRequest;
use App\Http\Controllers\Controller;
use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\customer\Customer;
use App\Models\invoice\Invoice;
use App\Models\order\Order;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\supplier\Supplier;
use App\Models\transaction\Transaction;
use App\Models\transaction\TransactionHistory;
use Illuminate\Support\Facades\DB;

/**
 * InvoicesController
 */
class PaymentsController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @param CreateInvoiceRequestNamespace $request
     * @return \App\Http\Responses\Focus\invoice\CreateResponse
     */
    public function payment(MakePaymentRequest $request)
    {
        //Input received from the request
        $transaction = $request->only(['amount', 'payment_date', 'method', 'account_id', 'note', 'bill_id', 'relation_id', 'type_id']);
        $amount = numberClean($transaction['amount']);
        $transaction['ins'] = auth()->user()->ins;
        $transaction['user_id'] = auth()->user()->id;
        $transaction['credit'] = $amount;
        $transaction['debit'] = $amount;
        $transaction['payment_date'] = date_for_database($transaction['payment_date']);
        unset($transaction['amount']);
        if ($amount > 0) {
            $this->store_payment($transaction);
        } else {
            return json_encode(array('status' => 'Success', 'message' => trans('transactions.zero_amount')));
        }
    }

    private function store_payment($transaction, $sign = '+')
    {
        DB::beginTransaction();

        switch ($transaction['relation_id']) {
            case 0 :
                if (access()->allow('invoice-manage')) {
                    $bill = Invoice::find($transaction['bill_id']);
                    $transaction['payer_id'] = $bill->customer_id;
                    $transaction['payer'] = $bill->customer->name;
                    $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                    $transaction['trans_category_id'] = $default_category['feature_value'];
                    $transaction['debit'] = 0;
                } else {
                    exit;
                }
                break;
            case 5:
                if (access()->allow('creditnote-manage')) {
                    $bill = Order::find($transaction['bill_id']);
                    $transaction['payer_id'] = $bill->customer_id;
                    $transaction['payer'] = $bill->customer->name;
                    $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                    $transaction['credit'] = 0;
                    $transaction['trans_category_id'] = $default_category['feature_value'];
                } else {
                    exit;
                }
                break;

            case 9:
                if (access()->allow('purchaseorder-manage')) {
                    $bill = Purchaseorder::find($transaction['bill_id']);
                    $transaction['payer_id'] = $bill->supplier_id;
                    $transaction['payer'] = $bill->supplier->name;
                    $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 10)->first('feature_value');
                    $transaction['credit'] = 0;
                    $transaction['trans_category_id'] = $default_category['feature_value'];
                } else {
                    exit;
                }
                break;

            case 10:
                if (access()->allow('stockreturn-manage')) {
                    $bill = Order::find($transaction['bill_id']);
                    $transaction['payer_id'] = $bill->customer_id;
                    $transaction['payer'] = $bill->customer->name;
                    $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                    $transaction['debit'] = 0;
                    $transaction['trans_category_id'] = $default_category['feature_value'];
                } else {
                    exit;
                }
                break;

        }


        if ($bill->id) {


            if ($transaction['method'] == 'Wallet') {
                $available_balance = $bill->customer->balance;

                if ($available_balance >= $transaction['credit']) {
                    $r_wallet = $available_balance - $transaction['credit'];
                    $bill->customer->balance = $r_wallet;
                    $bill->customer->save();
                    $note = trans('payments.paid_amount') . ' ' . amountFormat($transaction['credit']);
                    TransactionHistory::create(array('party_id' => $bill->customer->id, 'user_id' => auth()->user()->id, 'note' => $note . ' ' . $transaction['note'], 'relation_id' => 11, 'ins' => auth()->user()->ins));
                } elseif ($transaction['credit'] > $available_balance and $available_balance > 0) {
                    $transaction['credit'] = $available_balance;
                    $bill->customer->balance = 0;
                    $bill->customer->save();
                    $note = trans('payments.paid_amount') . ' ' . amountFormat($available_balance);
                    TransactionHistory::create(array('party_id' => $bill->customer->id, 'user_id' => auth()->user()->id, 'note' => $note . ' ' . $transaction['note'], 'relation_id' => 11, 'ins' => auth()->user()->ins));

                } else {
                    echo json_encode(array('status' => 'Success', 'message' => trans('transactions.zero_balance')));
                    exit();
                }

            }

            try {
                $result = Transaction::create($transaction);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
                return false;
            }
            $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first();
            if ($dual_entry['feature_value']) {
                $transaction2 = $transaction;
                switch ($transaction['relation_id']) {
                    case 0 :
                        $transaction2['account_id'] = $dual_entry['value1'];
                        $transaction2['debit'] = $transaction['credit'];
                        $transaction2['credit'] = $transaction['debit'];
                        break;
                    case 5 :
                        $transaction2['account_id'] = $dual_entry['value2'];
                        $transaction2['debit'] = $transaction['credit'];
                        $transaction2['credit'] = $transaction['debit'];
                        break;
                    case 9 :
                        $transaction2['account_id'] = $dual_entry['value2'];
                        $transaction2['debit'] = $transaction['credit'];
                        $transaction2['credit'] = $transaction['debit'];
                        break;
                          case 10 :
                        $transaction2['account_id'] = $dual_entry['value2'];
                        $transaction2['debit'] = $transaction['credit'];
                        $transaction2['credit'] = $transaction['debit'];
                        break;
                }
                try {
                    Transaction::create($transaction2);
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollback();
                    echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
                    return false;
                }

            }


            if ($result->id && $sign == '+') {
                $account = Account::find($transaction['account_id']);
                switch ($transaction['relation_id']) {
                    case 0 :
                        $account->balance = $account->balance + $transaction['credit'];

                        $due = $bill->total - $bill->pamnt - $transaction['credit'];
                        $due2 = $bill->pamnt + $transaction['credit'];
                        break;
                    case 5:
                        $account->debit = $account->debit + $transaction['debit'];

                        $due = $bill->total - $bill->pamnt - $transaction['debit'];
                        $due2 = $bill->pamnt + $transaction['debit'];
                        break;
                    case 9:
                        $account->debit = $account->debit + $transaction['debit'];

                        $due = $bill->total - $bill->pamnt - $transaction['debit'];
                        $due2 = $bill->pamnt + $transaction['debit'];
                        break;
                        case 10:
                        $account->balance = $account->balance + $transaction['credit'];

                        $due = $bill->total - $bill->pamnt - $transaction['credit'];
                        $due2 = $bill->pamnt + $transaction['credit'];
                        break;
                }

                $account->save();

                if ($dual_entry['feature_value']) {
                    $account = Account::find($transaction2['account_id']);
                    switch ($transaction['relation_id']) {
                        case 0 :
                            $account->debit = $account->debit + $transaction2['debit'];
                            break;
                        case 5:
                            $account->balance = $account->balance + $transaction2['credit'];
                            break;
                        case 9:
                            $account->balance = $account->balance + $transaction2['credit'];
                            break;
                            case 10:
                            $account->balance = $account->balance + $transaction2['credit'];
                            break;
                    }
                    $account->save();
                }


                $bill->pmethod = $transaction['method'];

                if ($due <= 0.00) {
                    $bill->pamnt = $bill->total;
                    $bill->status = 'paid';

                } elseif ($due2 < $bill->total and $transaction['credit'] > 0) {

                    $bill->pamnt = $bill->pamnt + $transaction['credit'];

                    $bill->status = 'partial';
                }
                $bill->save();
                $due = $bill->total - $bill->pamnt;
            }


            $transaction['row'] = ' <tr><th scope="row">*</th><td><a href="' . route('biller.print_payslip', [$result->id, 1, 1]) . '" class="btn btn-blue btn-sm"><span class="fa fa-print" aria-hidden="true"></span></a> <p class="text-muted">' . $transaction['payment_date'] . '</p></td><td><p class="text-muted">' . $transaction['method'] . '</p></td><td class="text-right">' . amountFormat(@$transaction['debit']) . '</td><td class="text-right">' . amountFormat($transaction['credit']) . '</td><td class="">' . $transaction['note'] . '</td></tr>';

            echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.transactions.created') . ' <a href="' . route('biller.print_payslip', [$result->id, 1, 1]) . '" class="btn btn-primary btn-lg"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '</a> &nbsp; &nbsp;', 'par1' => trans('payments.' . $bill->status), 'par2' => $transaction['method'], 'par3' => $transaction['row'], 'payment_made' => numberFormat($bill->pamnt), 'payment_due' => numberFormat($due), 'remains' => numberFormat($due)));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => trans('general.error')));
        }

        DB::commit();
    }

    public function bill_bulk_payment(MakePaymentRequest $request)
    {

        //Input received from the request
        $transaction = $request->only(['amount', 'payment_date', 'method', 'account_id', 'note', 'cid', 'relation_id']);
        $transaction['ins'] = auth()->user()->ins;
        $transaction['user_id'] = auth()->user()->id;
        $transaction['credit'] = numberClean($transaction['amount']);
        $transaction['debit'] = numberClean($transaction['amount']);
        $transaction['payment_date'] = date_for_database($transaction['payment_date']);
        $transaction['payer_id'] = $transaction['cid'];
        unset($transaction['amount']);
        unset($transaction['cid']);
        $this->bulk_payment($transaction);


    }

    private function bulk_payment($transaction, $sign = '+')
    {
        DB::beginTransaction();

        switch ($transaction['relation_id']) {
            case 0 :
                $person = Customer::find($transaction['payer_id']);
                $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                $transaction['trans_category_id'] = $default_category['feature_value'];
                $transaction['debit'] = 0;
                break;
            case 9:
                $person = Supplier::find($transaction['payer_id']);
                $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                $transaction['trans_category_id'] = $default_category['feature_value'];
                $transaction['credit'] = 0;
                break;

        }


        if ($person->id) {
            $sum = $person->invoices->whereIn('status', array('due', 'partial'));
            $due = $sum->sum('total') - $sum->sum('pamnt');
            $due_static = numberFormat($due);
            $due_static = numberClean($due_static);
            $paid_static = 0;
            $invoices = $person->invoices->whereIn('status', array('due', 'partial'));

            $amount_posted = $transaction['credit'];

            if ($due_static >= $transaction['credit']) {

                foreach ($invoices as $item) {

                    if ($item->status == 'due' and $amount_posted >= $item->total) {
                        $item->pamnt = $item->total;
                        $item->status = 'paid';
                        $item->save();
                        $amount_posted = $amount_posted - $item->total;
                        $paid_static += $item->total;

                    } elseif ($item->status == 'partial' and $amount_posted >= ($item->total - $item->pamnt)) {
                        $amount = $item->total - $item->pamnt;
                        $item->pamnt += $amount;
                        $item->status = 'paid';
                        $item->save();

                        $amount_posted = $amount_posted - $amount;
                        $paid_static += $amount;
                    } elseif ($amount_posted > 0) {
                        $item->pamnt = $amount_posted;
                        $item->status = 'partial';
                        $item->save();
                        $amount_posted = 0;
                        $paid_static += $amount_posted;
                    } else {
                        break;
                    }
                }


                try {
                    $result = Transaction::create($transaction);
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollback();
                    echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_account') . $e->getCode()));
                    return false;
                }
                $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first();
                if ($dual_entry['feature_value']) {
                    $transaction2 = $transaction;
                    switch ($transaction['relation_id']) {
                        case 0 :
                            $transaction2['account_id'] = $dual_entry['value1'];
                            $transaction2['debit'] = $transaction['credit'];
                            $transaction2['credit'] = $transaction['debit'];
                            break;
                        case 9 :
                            $transaction2['account_id'] = $dual_entry['value2'];
                            $transaction2['debit'] = $transaction['credit'];
                            $transaction2['credit'] = $transaction['debit'];
                            break;
                    }

                    try {
                        Transaction::create($transaction2);
                    } catch (\Illuminate\Database\QueryException $e) {
                        DB::rollback();
                        echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_account') . $e->getCode()));
                        return false;
                    }
                }

                if ($result->id && $sign == '+') {
                    $account = Account::find($transaction['account_id']);
                    switch ($transaction['relation_id']) {
                        case 0 :
                            $account->balance = $account->balance + $transaction['credit'];
                            break;

                        case 9:
                            $account->balance = $account->balance - $transaction['debit'];
                            break;
                    }

                    $account->save();

                    if ($dual_entry['feature_value']) {
                        $account = Account::find($transaction2['account_id']);
                        switch ($transaction['relation_id']) {
                            case 0 :
                                $account->balance = $account->balance - $transaction2['debit'];
                                break;

                            case 9:
                                $account->balance = $account->balance + $transaction2['credit'];
                                break;
                        }
                        $account->save();
                    }

                }


                DB::commit();
            }
        }


    }
}
