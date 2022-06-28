<?php

namespace App\Http\Requests\Focus\quote;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('quote-create');
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
                'customer_id' => 'required|integer|min:1',
                'tid' => 'required|integer|min:1',
                'total' => 'required',
                'term_id' => 'required|integer|min:1',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'customer_id.min' => trans('customers.valid_enter'),
            'tid.required' => trans('invoices.invalid_number'),
            'tid.min' => trans('invoices.invalid_number'),
            'term_id.required' => trans('terms.required'),
        ];
    }
}
