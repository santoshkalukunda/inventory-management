<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
            'date' => 'required',
            'payment' => 'required|numeric',
            'total' => 'required|numeric',
            "discount" => 'nullable|numeric',
            "discount_in" => 'nullable',
            "vat" => 'nullable|numeric',
            'net_total' => 'required|numeric',
            'due' => 'required|numeric',
            'remarks' => 'nullable',
        ];
    }
}
