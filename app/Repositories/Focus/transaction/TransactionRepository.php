<?php

namespace App\Repositories\Focus\transaction;

use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use DB;
use Carbon\Carbon;
use App\Models\transaction\Transaction;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Transaction::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        $q = $this->query();
        $q->when(request('p_rel_type') == 0 AND request('p_rel_id'), function ($q) {
            return $q->where('trans_category_id', '=', request('p_rel_id', 0));
        });
        $q->when(request('p_rel_type') == 1 AND request('p_rel_id'), function ($q) {
            $q->where('payer_id', '=', request('p_rel_id', 0));
            return $q->where('relation_id', '=', 0);
        });
        $q->when(request('p_rel_type') == 2 AND request('p_rel_id'), function ($q) {
            return $q->where('user_id', '=', request('p_rel_id', 0));
        });
        $q->when(request('p_rel_type') == 9 AND request('p_rel_id'), function ($q) {
            return $q->where('account_id', '=', request('p_rel_id', 0));
        });
        $q->when(request('p_rel_type') == 3 AND request('p_rel_id'), function ($q) {
            $q->where('payer_id', '=', request('p_rel_id', 0));
            return $q->where('relation_id', '=', 3);
        });

             $q->when(request('p_rel_type') ==4 AND request('p_rel_id'), function ($q) {
            $q->where('payer_id', '=', request('p_rel_id', 0));
            return $q->where('relation_id', '=', 9);
        });

        return $q->get(['id', 'trans_category_id', 'debit', 'credit', 'account_id', 'relation_id', 'payer_id', 'payment_date']);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function create(array $input)
    {
        $input['payment_date'] = date_for_database($input['payment_date']);
        $ac2 = @$input['account_id2'];
        $input['credit'] = numberClean($input['credit']);
        $input['debit'] = numberClean($input['debit']);
        unset($input['account_id2']);
        DB::beginTransaction();
        $input = array_map( 'strip_tags', $input);
        $result = Transaction::create($input);
        $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first('feature_value');

        $account = Account::find($input['account_id']);
        $account->balance = $account->balance + $input['credit'];
        $account->debit = $account->debit + $input['debit'];
        $account->save();

        if ($dual_entry['feature_value']) {
            $input2 = $input;
            $input2['account_id'] = $ac2;
            $input2['debit'] = $input['credit'];
            $input2['credit'] = $input['debit'];
            $result2 = Transaction::create($input2);
            $account2 = Account::find($input2['account_id']);
            $account2->balance = $account2->balance + $input2['credit'];
            $account2->debit = $account2->debit + $input2['debit'];
            $account2->save();

        }

        DB::commit();
        if ($result['id']) {
            $feature = feature(11);
            $alert = json_decode($feature->value2, true);
            if ($alert['new_trans']) {
                $mail = array();
                $mail['mail_to'] = $feature->value1;
                $mail['customer_name'] = trans('transactions.transaction');
                $mail['subject'] = trans('meta.new_transaction_alert') . '#' . $result['id'];
                $mail['text'] = trans('transactions.transaction') . ' #' . $result['id'] . '<br>' . trans('general.amount') . '<br>Dr ' . amountFormat($input['debit']) . ' <br>Cr ' . amountFormat($input['credit']) . '<br> - ' . $input['note'];
                business_alerts($mail);
            }
            return $result['id'];
        }
        throw new GeneralException(trans('exceptions.backend.transactions.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Transaction $transaction
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Transaction $transaction, array $input)
    {

        //if ($transaction->update($input))
        //    return true;

        throw new GeneralException(trans('exceptions.backend.transactions.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Transaction $transaction
     * @return bool
     * @throws GeneralException
     */
    public function delete(Transaction $transaction)
    {
        $feature = feature(11);
        $alert = json_decode($feature->value2, true);
        if ($alert['del_trans']) {
            $mail = array();
            $mail['mail_to'] = $feature->value1;
            $mail['customer_name'] = trans('transactions.transaction');
            $mail['subject'] = trans('meta.delete_transaction_alert') . '#' . $transaction->id;
            $mail['text'] = trans('transactions.transaction') . ' #' . $transaction->id . '<br>' . trans('general.amount') . '<br>Dr ' . amountFormat($transaction->debit) . ' <br>Cr ' . amountFormat($transaction->credit) . '<br> - ' . $transaction->note;
            business_alerts($mail);
        }
         DB::beginTransaction();
        $account = Account::find($transaction->account_id);
        $account->debit -= $transaction->debit;
        $account->balance -= $transaction->credit;
        $account->save();
        if ($transaction->delete()) {
              DB::commit();
            return true;
        }
          DB::rollback();

        throw new GeneralException(trans('exceptions.backend.transactions.delete_error'));
    }
}
