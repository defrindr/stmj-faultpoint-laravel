<?php

namespace App\Http\Controllers;

use App\Models\HariTidakEfektif;
use App\Http\Requests\HariTidakEfektifRequest;
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
        return view('hari-tidak-efektif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = [
            "0" => "Hari Libur Nasional",
            "1" => "Hari Libur Optional",
        ];

        return view('hari-tidak-efektif.create',compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HariTidakEfektifRequest $request)
    {
        // Set to kapital
        $request->request->add(["keterangan" => ucfirst($request->keterangan)]);

        $hariTidakEfektif = new HariTidakEfektif( $request->all() );

        if($hariTidakEfektif->save())
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('success','Hari tidak efektif berhasil ditambahkan.');
        else
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('error','Hari tidak efektif gagal ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function edit(HariTidakEfektif $hariTidakEfektif)
    {
        $status = [
            "0" => "Hari Libur Nasional",
            "1" => "Hari Libur Optional",
        ];
        
        return view('hari-tidak-efektif.edit',
            compact('hariTidakEfektif', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function update(HariTidakEfektifRequest $request, HariTidakEfektif $hariTidakEfektif)
    {
        $schema = [
            "keterangan" => ucfirst( $request->keterangan ),
            "status" => $request->status
        ];

        if( $hariTidakEfektif->update( $schema ) )
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('success','Hari tidak efektif berhasil diubah');
        else
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('error','Hari tidak efektif gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HariTidakEfektif  $hariTidakEfektif
     * @return \Illuminate\Http\Response
     */
    public function destroy(HariTidakEfektif $hariTidakEfektif)
    {
        if($hariTidakEfektif->delete())
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('success', 'Hari tidak efektif berhasil dihapus');
        else
            return redirect()
                ->route('hari-tidak-efektif.index')
                ->with('error', 'Hari tidak efektif gagal dihapus');
    }

    /**
     * Display JSON of Hari tidak efektif
     */
    public function json(){

        $hariTidakEfektif = HariTidakEfektif::orderBy('id','DESC')
            ->select(['id','tanggal','status','keterangan'])
            ->get();

        $datatables = datatables()
            ->of($hariTidakEfektif)
            ->addColumn('action',function($data){
                $routeUpdate = route('hari-tidak-efektif.edit',[
                        'hari_tidak_efektif' => $data->id,
                    ]);
                $routeDestroy = route('hari-tidak-efektif.destroy',[
                        'hari_tidak_efektif' => $data->id,
                    ]);

                $token = csrf_token();
                $csrf = "<input type='hidden' value='$token' name='_token'>";
                $method = "<input type='hidden' value='DELETE' name='_method'>";
                
                $buttonUpdate = "
                            <a href='$routeUpdate' class='btn btn-primary mb-1 mr-1'>
                                    <i class='fa fa-pencil-alt'></i> Ubah</a>";
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
            ->editColumn('tanggal',function($data){
                return \CStr::date($data->tanggal);
            })
            ->editColumn('status',function($data){
                return $data->getStatus();
            })
            ->make(true);
        return $datatables;
    }
}
