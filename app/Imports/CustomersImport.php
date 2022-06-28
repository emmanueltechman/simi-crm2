<?php

namespace App\Imports;

use App\Models\customer\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel, WithBatchInserts, WithValidation, WithStartRow
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
        if (isset($this->data['password'])) $password = $this->data['password']; else $password = rand(999, 9999) . 'x@q' . rand(999, 9999);
        ++$this->rows;
           if (count($row) == 20) {
               return new Customer([
                   'employee_id' => auth()->user()->id,
                   'name' => $row[0],
                   'phone' => $row[1],
                   'address' => $row[2],
                   'city' => $row[3],
                   'region' => $row[4],
                   'country' => $row[5],
                   'postbox' => $row[6],
                   'email' =>  $row[7],
                   'company' => $row[8],
                   'taxid' => $row[9],
                   'name_s' => $row[10],
                   'phone_s' => $row[11],
                   'email_s' => $row[12],
                   'address_s' => $row[13],
                   'city_s' => $row[14],
                   'region_s' => $row[15],
                   'country_s' => $row[16],
                   'postbox_s' => $row[17],
                   'balance' => $row[18],
                   'docid' => $row[19],
                   'ins' => auth()->user()->ins,
                   'password' => $password
               ]);
           }
           return false;

    }

    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required',
            '7' => 'required|email',
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
