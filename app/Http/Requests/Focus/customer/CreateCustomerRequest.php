<?php

namespace App\Http\Requests\Focus\customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('customer-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
         public function rules()
    {
        $rules = array();

        return $rules;
    }

    public function messages()
    {
        return [
            'company.required' => trans('customers.valid_enter'),
        ];
    }
}
