<?php

namespace App\Http\Controllers;

use App\Models\HariTidakEfektif;
use Illuminate\Http\Request;

class HariTidakEfektifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $HariTidakEfektif=HariTidakEfektif::all();
        return view('hari-tidak-efektif.index',['HariTidakEfektif' => $HariTidakEfektif]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('hari-tidak-efektif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $hari=new hariTidakEfektif;
        // $hari->tanggal=$request->tanggal;
        // $hari->status=1;
        // $hari->keterangan=$request->keterangan;
        // $hari->save();
        $request->validate([
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);
        HariTidakEfektif::create([
            'tanggal'=>$request->tanggal,
            'status'=>1,
            'keterangan'=>$request->keterangan
        ]);
    //     HariTidakEfektif::create($request->all());
       return redirect('/hari-tidak-efektif')->with('status','Berhasil Menambahkan Hari Tidak Efektif');
    // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function show(HariTidakEfektif $hariTidakEfektif)
    {
        //
       // return $hariTidakEfektif;
         return view('hari-tidak-efektif.show',compact('hariTidakEfektif'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function edit(HariTidakEfektif $hariTidakEfektif)
    {
        //
        return view('hari-tidak-efektif.edit',compact('hariTidakEfektif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HariTidakEfektif $hariTidakEfektif)
    {
        //
        //return $request;
        $request->validate([
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);
        hariTidakEfektif::where('id',$hariTidakEfektif->id)
        ->update([
                'tanggal'=>$request->tanggal,
                'keterangan'=>$request->keterangan
        ]);
        return redirect('/hari-tidak-efektif')->with('status','Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function destroy(HariTidakEfektif $hariTidakEfektif)
    {
        //
        HariTidakEfektif::destroy($hariTidakEfektif->id);
        return redirect('/hari-tidak-efektif')->with('status','Data Berhasil Dihapus');
    }
}
