<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HariEfektifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // enable route
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
            // "status" => "required",
        ];
    }
}
