<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class HariTidakEfektifRequest extends FormRequest
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
            'keterangan' => 'required',
            'status' => 'required|numeric|min:0|max:1'
        ];

        if($request->isMethod('POST')){
            $rules += ['tanggal' => 'required|date'];
        }

        return $rules;
    }
}
