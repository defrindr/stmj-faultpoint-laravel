<?php

namespace App\Http\Controllers;

use App\Models\KategoriPoint;
use App\Http\Requests\KategoriPointRequest;
use Illuminate\Http\Request;
use DB;


class KategoriPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori-point.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisPoint = [
            'positif',
            'negatif'
        ];
        
        return view('kategori-point.create',compact('jenisPoint'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriPointRequest $request)
    {
        $kategoriPoint = new KategoriPoint( $request->all() );

        if($kategoriPoint->save())
            return redirect()
                ->route('kategori-point.index')
                ->with('success', 'Kategori point berhasil ditambahkan');
        else
            return redirect()
                ->route('kategori-point.index')
                ->with('error', 'Kategori point gagal ditambahkan');
    }

    /**
     * Display specific resource
     * 
     * @param \App\Models\KategoriPoint $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriPoint $kategoriPoint){
        return view('kategori-point.show', compact('kategoriPoint'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriPoint $kategoriPoint)
    {
        $jenisPoint = [
            'positif',
            'negatif'
        ];

        return view('kategori-point.edit', compact('kategoriPoint','jenisPoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function update(KategoriPointRequest $request, KategoriPoint $kategoriPoint)
    {
        if($kategoriPoint->update( $request->all() ))
            return redirect()
                ->route('kategori-point.index')
                ->with('success', 'Kategori point berhasil diubah');
        else
            return redirect()
                ->route('kategori-point.index')
                ->with('success', 'Kategori point gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KategoriPoint  $kategoriPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriPoint $kategoriPoint)
    {
        DB::beginTransaction();
        try{
            $kategoriPoint->delete();
            DB::commit();
            return redirect()
                ->route('kategori-point.index')
                ->with('success', 'Kategori point berhasil dihapus');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('kategori-point.index')
                ->with('error', 'Kategori point gagal dihapus. Masih ada data point yang ter-relasi dengan data ini.');
        }
    }

    /**
     * Display JSON Datatable Data
     * 
     */
    public function json(){
        $kategoriPoint = KategoriPoint::orderBy('created_at','DESC')
            ->select(['id','nama','jenis_point'])
            ->get();

        $datatables = datatables()
            ->of($kategoriPoint)
            ->addColumn('action',function($data){
                $routeUpdate = route('kategori-point.edit',$data);
                $routeDetail = route('kategori-point.show',$data);
                $routeDestroy = route('kategori-point.destroy',$data);

                $token = csrf_token();
                $csrf = "<input type='hidden' value='$token' name='_token'>";
                $method = "<input type='hidden' value='DELETE' name='_method'>";
                
                $buttonUpdate = "
                            <a href='$routeUpdate' class='btn btn-primary mb-1 mr-1'>
                                    <i class='fa fa-pencil-alt'></i> Ubah</a>";
                $buttonDetail = "
                            <a href='$routeDetail' class='btn btn-warning mb-1 mr-1'>
                                    <i class='fa fa-eye'></i> Detail</a>";
                $buttonDestroy = "
                            <form action='$routeDestroy' method='post' class='d-inline-block'> 
                                $csrf 
                                $method 
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <i class='fa fa-trash'></i> 
                                    Hapus
                                </button>
                            </form>";
                
                $html = "$buttonUpdate $buttonDetail $buttonDestroy";

                return $html;
            })
            ->editColumn('jenis_point',function($data){
                return $data->getJenisPoint();
            })
            ->make(true);

        return $datatables;
    }
}
