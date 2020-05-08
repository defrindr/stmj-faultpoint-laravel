<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\KategoriPoint;
use App\Http\Requests\PointRequest;
use Illuminate\Http\Request;
use DB;

class PointController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function create(KategoriPoint $kategoriPoint)
    {
        return view('kategori-point.point.create', compact('kategoriPoint'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function store(PointRequest $request,KategoriPoint $kategoriPoint)
    {
        $request->request->add(['kategori_point_id' => $kategoriPoint->id]);
        
        $point = new Point( $request->all() );
        
        if($point->save())
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('success', 'Point berhasil ditambahkan');
        else
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('error', 'Point gagal ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriPoint  $kategoriPoint
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriPoint $kategoriPoint,Point $point)
    {
        return view('kategori-point.point.edit', compact('point','kategoriPoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriPoint  $kategoriPoint
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(PointRequest $request, KategoriPoint $kategoriPoint, Point $point)
    {
        if($point->update( $request->all() ))
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('success', 'Point berhasil diubah');
        else
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('error', 'Point gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriPoint  $kategoriPoint
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriPoint $kategoriPoint,Point $point)
    {
        DB::beginTransaction();
        try{
            $point->delete();
            DB::commit();
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('success', 'Point berhasil dihapus.');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('kategori-point.show', $kategoriPoint)
                ->with('error', 'Point gagal dihapus. Masih ada data kasus yang ter-relasi dengan data ini.');
        }
    }


    /**
     * Return JSON Data of Resource
     * 
     */
    public function json(KategoriPoint $kategoriPoint){
        $point = Point::where(['kategori_point_id' => $kategoriPoint->id])
            ->orderBy('created_at','DESC')
            ->get();

        $datatables = datatables()
            ->of($point)
            ->addColumn('action',function($data){
                $routeUpdate = route('kategori-point.show.edit',[$data->kategori_point_id,$data->id]);
                $routeDestroy = route('kategori-point.show.destroy',[$data->kategori_point_id,$data->id]);

                $token = csrf_token();
                $csrf = "<input type='hidden' value='$token' name='_token'>";
                $method = "<input type='hidden' value='DELETE' name='_method'>";
                
                $buttonUpdate = "
                            <a href='$routeUpdate' class='btn btn-primary mb-1 mr-1'>
                                <i class='fa fa-pencil-alt'></i> Ubah
                            </a>";
                $buttonDestroy = "
                            <form action='$routeDestroy' method='post' class='d-inline-block'> 
                                $csrf 
                                $method 
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <i class='fa fa-trash'></i> 
                                    Hapus
                                </button>
                            </form>";
                
                $html = "$buttonUpdate $buttonDestroy";

                return $html;
            })
            ->editColumn('interval_waktu',function($data){
                return $data->getIntervalWaktu();
            })
            ->editColumn('point',function($data){
                return $data->getPoint();
            })
            ->make(true);

        return $datatables;
    }


}
