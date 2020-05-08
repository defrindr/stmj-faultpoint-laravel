<?php

namespace App\Http\Requests;

use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AbsensiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $permission = false;
        if($request->isMethod('PUT')){
            if(\Roles::has('Super Admin')) $permission = true;
        }else{
            $permission = true;
        }

        return $permission;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [];
        if( $request->isMethod('PUT') ){
            $array = ['hadir','bolos','alpha','ijin','sakit'];

            $rules = [
                'id' => 'required|numeric',
                'siswa_nip' => 'required|numeric',
                'status' => "required|in:hadir,bolos,alpha,ijin,sakit",
                'keterangan' => 'required'
            ];
        }else{
            $rules = [
                'siswa_nip' => 'required|array',
                'status' => 'required|array',
                'keterangan' => 'required|array'
            ];
        }

        return $rules;
    }
}
