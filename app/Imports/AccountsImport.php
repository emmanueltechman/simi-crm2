<?php

namespace App\Imports;

use App\Models\account\Account;
use App\Models\customer\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AccountsImport implements ToModel, WithBatchInserts, WithValidation, WithStartRow
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
        ++$this->rows;
        if (count($row) == 6) {
            return new Account([
                'number' => $row[0],
                'holder' => $row[1],
                'balance' => $row[2],
                'code' => $row[3],
                'account_type' => $row[4],
                'note' => $row[5],
                'ins' => auth()->user()->ins
            ]);
        }
        return false;
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '4' => 'required|string',
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
