<?php

namespace App\Http\Controllers;

use App\models\Point;
use App\models\KategoriPoint;
use Illuminate\Http\Request;
use DB;
class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Point=Point::all();
        $KategoriPoint=KategoriPoint::all();
        return view('point.index',compact('Point','KategoriPoint'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $KategoriPoint=KategoriPoint::all();
        return view('point.create',compact('KategoriPoint'));
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
            'peraturan' => 'required',
            'interval_waktu' => 'required|numeric',
            'point' => 'required|numeric',
            'sanksi' => 'required',
            'kategori_point_id' => 'required',
        ]);
        Point::create([
            'peraturan'=>$request->peraturan,
            'interval_waktu'=>$request->interval_waktu,
            'point'=>$request->point,
            'sanksi'=>$request->sanksi,
            'kategori_point_id'=>$request->kategori_point_id
        ]);
    //     HariTidakEfektif::create($request->all());
       return redirect('/point')->with('status','Berhasil Menambahkan Point');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
        $KategoriPoint=KategoriPoint::all();
        return view('point.show',compact('point','KategoriPoint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        //
        $KategoriPoint=KategoriPoint::all();
        return view('point.edit',compact('point','KategoriPoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        //
        $request->validate([
            'peraturan' => 'required',
            'interval_waktu' => 'required|numeric',
            'point' => 'required|numeric',
            'sanksi' => 'required',
            'kategori_point_id' => 'required',
        ]);
        Point::where('id',$point->id)
        ->update([
            'peraturan'=>$request->peraturan,
            'interval_waktu'=>$request->interval_waktu,
            'point'=>$request->point,
            'sanksi'=>$request->sanksi,
            'kategori_point_id'=>$request->kategori_point_id
        ]);
        return redirect('/point')->with('status','Berhasil Mengubah Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
        Point::destroy($point->id);
        return redirect('/point')->with('status','Data Berhasil Dihapus');
    }
}
