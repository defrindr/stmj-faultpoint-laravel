<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class JurusanRequest extends FormRequest
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
        $rules = [];
        
        if($request->isMethod('PUT')){
            $rules += [
                "nama" => "required|unique:jurusan,nama,". $request->jurusan->id
            ];
        }else{
            $rules += [
                "nama" => "required|unique:jurusan,nama"
            ];
        }

        return $rules;
    }
}
