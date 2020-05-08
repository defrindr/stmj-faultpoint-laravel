<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Point;
use App\Models\KategoriPoint;
use App\Http\Requests\KasusRequest;
use Illuminate\Http\Request;
use DB;
use Roles;

class KasusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kasus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelasDB = Kelas::get();
        $kategoriPointDB = KategoriPoint::orderBy('jenis_point','DESC')
            ->get();
        $today = date('Y-m-d');

        $kelas = [];
        $kategoriPoint = [];

        foreach ($kelasDB as $row){
            $kelas += [ $row->id => $row->getPrefix() ];
        }
        foreach ($kategoriPointDB as $row){
            $kategoriPoint += [ $row->id => $row->nama. " ($row->jenis_point)" ];
        }

        return view('kasus.create', compact('kelas', 'kategoriPoint', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KasusRequest $request)
    {
        DB::beginTransaction();

        $user_id = auth()->user()->id;
        $request->request->add( ['user_id' => $user_id] );
        
        $siswa = Siswa::where( ['nip' => $request->siswa_nip] )
            ->first();
        $point = Point::where( ['id' => $request->point_id] )
            ->first();
        $kasus = new Kasus( $request->all() );

        try{
            $kasus->save();

            if($point->jenis_point == "positif"){
                $point_awal = $siswa->point_penghargaan;
                $total_point = $point_awal + $point->point;
                $siswa->update( ['point_penghargaan' => $total_point] );
            }else{
                $point_awal = $siswa->point_pelanggaran;
                $total_point = $point_awal + $point->point;
                $siswa->update( ['point_pelanggaran' => $total_point] );
            }
            
            DB::commit();

            return redirect()
                ->route('kasus.index')
                ->with('success','Kasus berhasil ditambahkan.');
        }catch(\Exception $e){
            DB::rollback();

            return redirect()
                ->route('kasus.index')
                ->with('error','Kasus gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kasus  $kasus
     * @return \Illuminate\Http\Response
     */
    public function show(Kasus $kasus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kasus  $kasus
     * @return \Illuminate\Http\Response
     */
    public function edit(Kasus $kasus)
    {
        if( Roles::checkAuthorization($kasus) == false ){
            return abort(403);
        }

        $today = date('Y-m-d');
        return view('kasus.edit', compact('kasus', 'today'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kasus  $kasus
     * @return \Illuminate\Http\Response
     */
    public function update(KasusRequest $request, Kasus $kasus)
    {
        $schema = [
            "tanggal" => $request->tanggal 
        ];

        $kasus->update($schema);
        return redirect()
            ->route('kasus.index')
            ->with('success', 'Kasus berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kasus  $kasus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kasus $kasus)
    {
        try{
            if( Roles::checkAuthorization($kasus) == false ){
                return abort(403);
            }
            
            $kasus->delete();

            return redirect()
                ->route('kasus.index')
                ->with('success', 'kasus berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()
                ->route('kasus.index')
                ->with('success', 'kasus gagal dihapus.');
        }
    }

    /**
     * Display data JSON for datatable
     */
    public function json(){

        if( Roles::has('Super Admin') ){
            $kasus = Kasus::orderBy('created_at','DESC')
                ->get();
        }else{
            $kasus = Kasus::where( ['user_id' => Roles::getId()] )
                ->orderBy('created_at','DESC')
                ->get();
        }


        $datatables = datatables()
            ->of($kasus)
            ->addColumn('tanggal',function($data){
                return \CStr::date($data->tanggal);
            })
            ->addColumn('action',function($data){
                $routeEdit = route('kasus.edit',$data);
                $routeDestroy = route('kasus.destroy',$data);
                $routeRollback = route('kasus.rollback',$data);
                $token = csrf_token();

                $csrf = "
                    <input type='hidden' name='_token' value='$token'>";
                $methodDelete = "
                    <input type='hidden' name='_method' value='delete'>";
                $methodPut = "
                    <input type='hidden' name='_method' value='put'>";

                $buttonEdit = "
                        <a href='$routeEdit' class='btn btn-primary mb-1 mr-1'>
                            <span class='fa fa-pencil-alt'></span> Ubah
                        </a>";
                $buttonRollback = "
                        <form  action='$routeRollback' class='d-inline-block' method='post'>
                            $csrf
                            $methodPut
                            <button class='btn btn-warning mb-1 mr-1 deleteAlerts'>
                                <span class='fa fa-sync'></span> Rollback
                            </button>
                        </form>";
                $buttonDestroy = "
                        <form  action='$routeDestroy' class='d-inline-block' method='post'>
                            $csrf
                            $methodDelete
                            <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                <span class='fa fa-trash-alt'></span> Hapus
                            </button>
                        </form>";

                $buttons = "$buttonEdit $buttonRollback $buttonDestroy";
                return $buttons;
            })
            ->addColumn('nama_siswa',function($data){
                return $data->siswa->nama;
            })
            ->addColumn('kategori_kasus',function($data){
                return $data->point->kategoriPoint->nama. " (". $data->point->kategoriPoint->jenis_point. ")";
            })
            ->addColumn('kelas',function($data){
                return $data->siswa->kelas->getPrefix();
            })
            ->addColumn('kasus',function($data){
                return $data->point->peraturan;
            })
            ->removeColumn([
                'user_id',
                'siswa_nip',
                'point_id',
                'created_at',
                'updated_at'
            ])
            ->make(true);

        return $datatables;
    }
    
    public function siswa(Request $request,Kelas $kelas){
        $search = $request->search;

        $siswa = Siswa::where(['kelas_id' => $kelas->id]);

        if($search != ''){
            $siswa = $siswa->where('nama','like',"%$search%")->limit(6)->get();
        }else{
            $siswa = $siswa->limit(6)->get();
        }

        $response = [];
        $selected = (int)$request->selected;

        foreach($siswa as $row){
            if($selected == $row->nip):
                array_push($response,[
                    'id' => $row->nip,
                    'text' => $row->nama,
                    'selected' => true,
                ]);
            else:
                array_push($response,[
                    'id' => $row->nip,
                    'text' => $row->nama
                ]);
            endif;
        }

        return response()->json($response);
    }
    public function point(Request $request,KategoriPoint $kategoriPoint){
        $search = $request->search;

        $point = Point::where( ['kategori_point_id' => $kategoriPoint->id] );

        if($search != ''){
            $point = $point->where('peraturan','like',"%$search%")->limit(6)->get();
        }else{
            $point = $point->limit(6)->get();
        }

        $response = [];
        $selected = (int)$request->selected;

        foreach($point as $row){
            if($selected == $row->id):
                array_push($response,[
                    'id' => $row->id,
                    'text' => $row->peraturan,
                    'selected' => true,
                ]);
            else:
                array_push($response,[
                    'id' => $row->id,
                    'text' => $row->peraturan
                ]);
            endif;
        }

        return response()->json($response);
    }

    public function getSiswa(Siswa $siswa){
        $kelas = Kelas::where( ['id' => $siswa->kelas_id] )
            ->first();
        $kasus = Kasus::where( ['siswa_nip' => $siswa->nip] )
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();

        $formatKasus = [];

        foreach($kasus as $row){
            array_push($formatKasus,[
                "tanggal" => \CStr::date($row->tanggal),
                "kasus" => $row->point->peraturan,
                "jenis_point" => $row->point->kategoriPoint->jenis_point,
            ]);
        }


        $response = [
            "nama" => $siswa->nama,
            "kelas" => $kelas->getPrefix(),
            "point_penghargaan" => $siswa->point_penghargaan. " Point",
            "point_pelanggaran" => $siswa->point_pelanggaran. " Point",
            "nama_wali" => $siswa->nama_wali,
            "no_telp_wali" => $siswa->no_telp_wali,
            "tiga_kasus_terakhir" => $formatKasus
        ];
        
        return response()->json($response);
    }

    public function getPoint(Point $point){
        return response()->json([
            'point' => $point->point. " Point"
        ]);
    }

    public function rollback(Kasus $kasus){

        if( Roles::checkAuthorization($kasus) == false ){
            return abort(403);
        }

        $siswa = Siswa::where( ['nip' => $kasus->siswa_nip] )
            ->first();
        $point = Point::where( ['id' => $kasus->point_id] )
            ->first();
        $jenis_point = KategoriPoint::where( ['id' => $point->kategori_point_id] )
            ->first()->jenis_point;

        DB::beginTransaction();
        
        try{
            if($jenis_point == "negatif"){
                $updatedData = $siswa->point_pelanggaran - $point->point;
                $siswa->update( ['point_pelanggaran' => $updatedData] );
            }else{
                $updatedData = $siswa->point_penghargaan - $point->point;
                $siswa->update( ['point_penghargaan' => $updatedData] );
            }
            $kasus->delete();
            DB::commit();
            return redirect()
                ->route('kasus.index')
                ->with('success', 'Kasus berhasil dirollback.');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('kasus.index')
                ->with('error', 'Kasus gagal dirollback.');
        }
    }



}
