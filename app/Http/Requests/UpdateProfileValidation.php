<?php

namespace App\Http\Requests;

use App\Rules\CheckMail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileValidation extends FormRequest
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
            'username' => 'required | min:6 | max:30',
            'bio' => 'required | min:6 | max:255',
            'phonenumber' => 'required | max:11 ',
            // 'email' => ['required', ' max:128 ', 'email', new CheckMail()],
            'addressNumber' => 'required | max:128',
            'township' => 'required | max:11',
            'state' => 'required | max:11',
            'favtype' => 'min:0',
            'Allergic' => 'required | min:6 | max:255',
            'Taste' => 'min:0'
        ];
    }
}
