<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class HariTidakEfektifRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'status' => 'required|in:0,1',
            'keterangan' => 'required|min:1'
        ];
        
        if( $request->isMethod('PUT') ){
            $rules += ['tanggal' => 'required|unique:hari_tidak_efektif,tanggal'];
        }

        return $rules;
    }
}
