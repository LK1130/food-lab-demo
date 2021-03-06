<?php

namespace App\Http\Requests;

use App\Rules\CheckSuggest;
use Illuminate\Foundation\Http\FormRequest;

class SuggestValidation extends FormRequest
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
            'suggest_type' => ['required', 'min:0', 'max:30', new CheckSuggest()],
            'note' => 'required|min:0|max:255'
        ];
    }
}
