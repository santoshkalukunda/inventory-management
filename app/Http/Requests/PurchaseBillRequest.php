<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseBillRequest extends FormRequest
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
            'order_date' => 'required',
            'shipping_date' => 'required',
            'bill_no' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'net_total' => 'required|numeric',
            'payment' => 'required|numeric',
            'due' => 'required|numeric',
        ];
    }
}
