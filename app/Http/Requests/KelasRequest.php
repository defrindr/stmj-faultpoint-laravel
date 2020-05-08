<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class KelasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorization = false;
        if(\Roles::has('Super Admin')) $authorization = true;

        return $authorization;
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
                "walikelas" => "required|unique:kelas,user_id,". $request->kelas->id
            ];
        }else{
            $rules += [
                "tahun_ajaran" => "required",
                "jurusan_id" => "required",
                "grade" => "required",
                "kelas" => "required",
                "walikelas" => "required|unique:kelas,user_id"
            ];
        }

        return $rules;
    }
}
