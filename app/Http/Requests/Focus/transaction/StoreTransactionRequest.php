<?php

namespace App\Http\Requests\Focus\transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('transaction-data');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


      public function rules()
    {
        $rules = array();
        if ($this->getMethod() == 'POST') {
            $rules = [
                   'account_id' => 'required|integer|min:1',
            'trans_category_id' => 'required|integer|min:1',
            'debit' => 'required',
            'credit' => 'required',
            'method' => 'required',
            'payment_date' => 'required',
            ];
        }
        return $rules;
    }

        public function messages()
    {
        return [
            'account_id.min' => trans('accounts.valid_enter'),
            'trans_category_id.required' => trans('transactioncategories.valid_enter'),
            'debit.required' => trans('transactions.debit_invalid'),
            'credit.required' => trans('transactions.credit_invalid'),
        ];
    }
}
