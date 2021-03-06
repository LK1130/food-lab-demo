<?php

namespace App\Http\Requests;

use App\Rules\CheckPayment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentValidation extends FormRequest
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
            'payment_name' => ['required', 'min:4', 'max:16', new CheckPayment()],
            'accountname' => 'required|min:0|max:1000000000|numeric',
            'note' => 'required|min:0|max:255'
        ];
    }
}
