<?php

namespace App\Http\Requests\Focus\product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('product-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
                'warehouse_id.*' => 'required|integer|min:1',
                'qty' => 'required|min:1',
                'productcategory_id' => 'required|integer|min:1',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'warehouse_id.required' => trans('warehouses.valid_enter'),
            'qty.required' => trans('invoices.invalid_number'),
            'productcategory_id.required' => trans('productcategories.valid_enter')

        ];
    }
}
