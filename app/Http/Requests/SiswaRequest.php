<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SiswaRequest extends FormRequest
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
        $rules = [
                'nama' => 'required',
                'alamat_rumah' => 'required',
                'alamat_domisili' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'no_telp' => 'required|numeric',
                'nama_wali' => 'required',
                'no_telp_wali' => 'required|numeric'
            ];
        if($request->isMethod("POST")){
            $rules += [
                'nip' => 'required|numeric|unique:siswa,nip',
            ];
        }else{
            $rules += [
                'nip' => 'required|numeric|unique:siswa,nip,'. $request->siswa->id,
            ];
        }
        

        return $rules;
    }
}
