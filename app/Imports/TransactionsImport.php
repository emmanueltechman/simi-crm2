<?php

namespace App\Imports;

use App\Models\account\Account;
use App\Models\customer\Customer;
use App\Models\transaction\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransactionsImport implements ToModel, WithBatchInserts, WithValidation, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $rows = 0;

    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }


    public function model(array $row)
    {

        if (isset($this->data['account'])) $account = $this->data['account']; else return false;
        if (isset($this->data['trans_category'])) $trans_category = $this->data['trans_category']; else return false;
        ++$this->rows;
        $r_debit = numberClean($row[1]);
        $r_credit = numberClean($row[2]);
   if (count($row) == 6) {
       $trans = new Transaction([
           'account_id' => $account,
           'trans_category_id' => $trans_category,
           'debit' => $r_debit,
           'credit' => $r_credit,
           'payer' => $row[3],
           'method' => $row[4],
           'payment_date' => date_for_database($row[0]),
           'user_id' => auth()->user()->id,
           'note' => $row[5],
           'ins' => auth()->user()->ins
       ]);

       $account = Account::find($account);
       $account->balance += $r_credit;
       $account->balance -= $r_debit;
       $account->save();
       return $trans;
   }
   return false;

    }

    public function rules(): array
    {
        return [
            '0' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function startRow(): int
    {
        return 2;
    }
}
