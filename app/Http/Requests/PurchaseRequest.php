<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'product_id' => 'required|exists:products,id',
        'batch_no' => 'nullable',
        'mf_date' => 'nullable',
        'exp_date' => 'nullable',
        'quantity' => 'required|numeric',
        'unit_id' => 'required|exists:units,id',
        'rate'=> 'required|numeric',
        'discount_in' => 'nullable',
        'discount'=> 'nullable|numeric',
        'vat' => 'nullable|numeric',
        'total' => 'required|numeric',
        'mrp' => 'required|numeric',
        ];
    }
}
