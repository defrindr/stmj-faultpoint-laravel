<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class KasusRequest extends FormRequest
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
            "tanggal" => "required|date|before_or_equal:". date('Y-m-d'),
        ];

        if($request->isMethod('POST')){
            $rules += [
                "siswa_nip" => "required|numeric",
                "point_id" => "required|numeric",
            ];
        }

        return $rules;
    }
}
