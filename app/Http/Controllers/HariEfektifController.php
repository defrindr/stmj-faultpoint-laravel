<?php

namespace App\Http\Controllers;

use App\Models\HariEfektif;
use App\Http\Requests\HariEfektifRequest;
use Illuminate\Http\Request;

class HariEfektifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hari-efektif.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HariEfektif  $hariEfektif
     * @return \Illuminate\Http\Response
     */
    public function update(HariEfektifRequest $request, HariEfektif $data)
    {
        $newStatus = ($data->status) ? 0 : 1;

        if($data->update([ 'status' => $newStatus ]) ){
            $json = [
                "success" => true,
                "message" => "Data berhasil diubah"
            ];
        }else{
            $json = [
                "success" => false,
                "message" => "Data gagal diubah"
            ];
        }
        return response()->json($json);
        
    }

    public function json(){
        $data = HariEfektif::get();

        
        return datatables()
            ->collection($data)
            ->addColumn('action',function($data){
                $checked = ($data->status) ? "checked" : "";
                $param = json_encode(["id" => $data->id,"token" => csrf_token()]);
                $button = "
                        <div class='onoffswitch'>
                            <input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch$data->id' $checked>
                            <label class='onoffswitch-label' for='myonoffswitch$data->id' 
                            onClick='event.preventDefault;
                                    update($param)'>
                                <span class='onoffswitch-inner'></span>
                                <span class='onoffswitch-switch'></span>
                            </label>
                        </div>";
                        
                return $button;
            })
            ->make(true);
    }

}
