<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            "name" => "required|min:6",
        ];

        if($request->isMethod('PUT')){
            $rules += [
                "email" => "required|email|unique:users,email,". $request->user->id,
            ];
        }else{
            $rules += [
                "email" => "required|email|unique:users,email",
                "password" => "required|min:6"
            ];
        }


        return $rules;
    }
}
