<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kasus;
use App\Http\Requests\SiswaRequest;
use Illuminate\Http\Request;
use DB;
use Roles;

class SiswaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kelas $kelas)
    {
        return view('siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiswaRequest $request, Kelas $kelas)
    {
        $schema = $request->all() + [
            'kelas_id' => $kelas->id,
            'point_pelanggaran' => 0,
            'point_penghargaan' => 0
        ];
        
        $siswa = new Siswa($schema);

        try{

            if($siswa->save()){
                return redirect()
                    ->route('siswa.show',[ $siswa, $kelas])
                    ->with('success','Siswa berhasil ditambahkan');
            }else{
                return redirect()
                    ->route('kelas.show', $kelas)
                    ->with('error','Siswa gagal ditambahkan.');
            }
        }catch(\Exception $e){
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('error','Siswa gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas, Siswa $siswa)
    {
        if($siswa->kelas_id === $kelas->id){
            if(Roles::has('Super Admin')){
                return view('siswa.show', compact('kelas', 'siswa'));
            }else{
                $isMatch = $kelas->user_id === Roles::getId();
                if($isMatch){
                    return view('siswa.show', compact('kelas', 'siswa'));
                }
                return abort(403);
            }
        }else{
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas, Siswa $siswa)
    {
        return view('siswa.edit', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(SiswaRequest $request, Kelas $kelas, Siswa $siswa)
    {
        if($siswa->update( $request->all() )){
            return redirect()
                ->route('siswa.show', [$kelas, $siswa] )
                ->with('success', 'Siswa berhasil diubah.');
        }else{
            return redirect()
                ->route('siswa.show', [$kelas, $siswa] )
                ->with('error', 'Siswa gagal diubah.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas,Siswa $siswa)
    {
        DB::beginTransaction();
        try{
            $siswa->delete();
            DB::commit();
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('success', 'Siswa berhasil dihapus.');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('error', 'Siswa gagal dihapus. Masih ada data absensi dan/atau kasus yang ter-relasi dengan data ini.');
        }
    }

    public function json(Kelas $kelas){
        if(Roles::has('Super Admin')){
            $siswa = Siswa::where( ['kelas_id' => $kelas->id] )
                    ->select( ['nip','nama','point_pelanggaran','point_penghargaan','kelas_id'] )
                    ->get();
        }else{
            $siswa = Siswa::where( ['kelas_id' => $kelas->id, 'kelas.user_id' => Roles::getId() ] )
                    ->join('kelas', 'kelas.id', 'kelas_id')
                    ->select( ['nip','nama','point_pelanggaran','point_penghargaan','kelas_id'] )
                    ->get();
        }

        $datatable = datatables()
            ->of($siswa)
            ->addColumn('action',function($data){
                $routeUpdate = route('siswa.edit', [$data->kelas_id, $data] );
                $routeDetail = route('siswa.show', [$data->kelas_id, $data] );
                $routeDestroy = route('siswa.destroy', [$data->kelas_id, $data] );

                $token = csrf_token();
                $csrf = "<input type='hidden' value='$token' name='_token'>";
                $method = "<input type='hidden' value='DELETE' name='_method'>";
                
                $buttonUpdate = "
                            <a href='$routeUpdate' class='btn btn-primary mb-1 mr-1'>
                                <i class='fa fa-pencil-alt'></i> Ubah
                            </a>";
                $buttonDetail = "
                            <a href='$routeDetail' class='btn btn-warning mb-1 mr-1'>
                                <i class='fa fa-eye'></i> Detail
                            </a>";
                $buttonDestroy = "
                            <form action='$routeDestroy' method='post' class='d-inline-block'> 
                                $csrf 
                                $method 
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                            </form>";
                

                if(\Roles::has('Super Admin')){
                    $button = "$buttonUpdate $buttonDetail $buttonDestroy";
                }else{
                    $button = "$buttonDetail";
                }
                return $button;
            })
            ->make(true);

        return $datatable;

    }

    public function getPelanggaran(Kelas $kelas,Siswa $siswa){
        $kasus = Kasus::join('point', 'point.id', 'point_id')
            ->join('kategori_point', 'kategori_point.id', 'point.kategori_point_id')
            ->join('siswa', 'siswa.nip', 'siswa_nip')
            ->where( ['kategori_point.jenis_point' => 'negatif'] )
            ->select( ['tanggal', 'point.peraturan', 'point.point'] )
            ->get();

        $datatables = datatables()
            ->of($kasus)
            ->addColumn('petugas', function($data){
                return $data->name;
            })
            ->editColumn('tanggal', function($data){
                return \CStr::date($data->tanggal);
            })
            ->make(true);

        return $datatables;
    }
    public function getPenghargaan(Kelas $kelas,Siswa $siswa){
        $kasus = Kasus::join('point', 'point.id', 'point_id')
            ->join('kategori_point', 'kategori_point.id', 'point.kategori_point_id')
            ->join('siswa', 'siswa.nip', 'siswa_nip')
            ->where( ['kategori_point.jenis_point' => 'positif'] )
            ->select( ['tanggal', 'point.peraturan', 'point.point'] )
            ->get();

        $datatables = datatables()
            ->of($kasus)
            ->addColumn('petugas', function($data){
                return $data->name;
            })
            ->editColumn('tanggal', function($data){
                return \CStr::date($data->tanggal);
            })
            ->make(true);

        return $datatables;
    }
}
