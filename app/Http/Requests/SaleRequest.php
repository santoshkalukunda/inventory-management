<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'store_id' => 'required|exists:stores,id',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|numeric',
            'rate'=> 'required|numeric',
            'discount' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
        ];
    }
}
