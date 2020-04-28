<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

use App\Http\Requests\JurusanRequest;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
         return view('jurusan.index');
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JurusanRequest $request)
    {
        $data = new Jurusan($request->all());

        if($data->save()){
            return redirect()->route('jurusan.index')->with('success','Jurusan berhasil disimpan');
        }else{
            return redirect()->route('jurusan.index')->with('error','Jurusan gagal disimpan');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit',[
            'jurusan' => $jurusan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function update(JurusanRequest $request, Jurusan $jurusan)
    {
        if($jurusan->update(
            $request->all()
        )){
            return redirect()->route('jurusan.index')->with('success','Jurusan berhasil diubah');
        }else{
            return redirect()->route('jurusan.index')->with('error','Jurusan gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurusan $jurusan)
    {
        $nama = $jurusan->nama;

        if($jurusan->delete()){
            return redirect()->route('jurusan.index')->with('success',"Jurusan $nama berhasil dihapus");
        }else{
            return redirect()->route('jurusan.index')->with('success',"Jurusan $nama gagal dihapus");
        }
    }


    public function json()
    {
        $data = Jurusan::all();

        return datatables()
                ->of($data)
                ->addColumn('action',function($data){
                    $routeEdit = route('jurusan.edit',['jurusan' => $data]);
                    $routeDelete = route('jurusan.destroy',['jurusan' => $data]);
                    $token = csrf_token();

                    $button = "
                            <a  href='$routeEdit' class='btn btn-primary mb-1 mr-1'>
                                <span class='fa fa-pencil-alt'></span> Ubah
                            </a>
                            <form  action='$routeDelete' class='d-inline-block' method='post'>
                                <input type='hidden' name='_method' value='delete'>
                                <input type='hidden' name='_token' value='$token'>
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <span class='fa fa-trash-alt'></span> Hapus
                                </button>
                            </a>
                            ";
                    return $button;
                })
                ->make(true);
    }

}
