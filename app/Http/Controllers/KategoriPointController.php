<?php

namespace App\Http\Controllers;

use App\models\KategoriPoint;
use Illuminate\Http\Request;

class KategoriPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $KategoriPoint=KategoriPoint::all();
        return view('kategori-point.index',['KategoriPoint' => $KategoriPoint]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('kategori-point.create');
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
        $request->validate([
            'nama' => 'required',
            'jenis_point' => 'required',
        ]);
        KategoriPoint::create([
            'nama'=>$request->nama,
            'jenis_point'=>$request->jenis_point
        ]);
    //     HariTidakEfektif::create($request->all());
       return redirect('/kategori-point')->with('status','Berhasil Menambahkan Kategori Point');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriPoint $kategoriPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriPoint $kategoriPoint)
    {
        //
        return view('kategori-point.edit',compact('kategoriPoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KategoriPoint $kategoriPoint)
    {
        //
        $request->validate([
            'nama' => 'required',
            'jenis_point' => 'required',
        ]);
        kategoriPoint::where('id',$kategoriPoint->id)
        ->update([
            'nama'=>$request->nama,
            'jenis_point'=>$request->jenis_point
        ]);
        return redirect('/kategori-point')->with('status','Berhasil Mengubah Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriPoint $kategoriPoint)
    {
        //
        KategoriPoint::destroy($kategoriPoint->id);
        return redirect('/kategori-point')->with('status','Data Berhasil Dihapus');
    }
}
