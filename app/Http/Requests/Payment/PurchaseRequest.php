<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\JsonRequest;

class PurchaseRequest extends JsonRequest
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
            'customerId' => ['required','numeric', 'gt:0'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ];
    }

}
