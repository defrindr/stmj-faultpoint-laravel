<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\Kasus;
use Illuminate\Http\Request;
use App\Http\Requests\KelasRequest;
use DB;
use Roles;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun = [];
        
        $startYear = date('Y');
        $endYear = date('Y') + 6;

        while($startYear < $endYear){
            $schema = $startYear. "/". ($startYear+1);
            array_push($tahun,$schema);
            $startYear += 1;
        }

        $jurusan = Jurusan::select(['id','nama'])->get();

        return view('kelas.create',compact('jurusan','tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KelasRequest $request)
    {
        $schema = [
            "user_id" => $request->walikelas,
            "jurusan_id" => $request->jurusan_id,
            "grade" => strtoupper($request->grade),
            "kelas_x" => ($request->kelas == "x" ? true : false),
            "kelas_xi" => ($request->kelas == "xi" ? true : false),
            "kelas_xii" => ($request->kelas == "xii" ? true : false),
            "tahun_ajaran" => $request->tahun_ajaran,
        ];
        
        $kelas = new Kelas($schema);

        if($kelas->save()){
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('success', 'Kelas berhasil dibuat.');
        }else{
            return redirect()
                ->route('kelas.create')
                ->with('error', 'Kelas gagal dibuat.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        $kasus = Kasus::join('siswa', 'siswa.nip', 'siswa_nip')
            ->where( ['kelas_id' => $kelas->id] )
            ->orderBy('kasus.created_at','ASC')
            ->limit(3)
            ->get();

        if( Roles::checkAuthorization($kelas) == false ){
            return abort(403);
        }

        return view('kelas.show', compact('kelas','kasus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(KelasRequest $request, Kelas $kelas)
    {
        $schema = [
            "user_id" => $request->walikelas
        ];

        if($kelas->update($schema)){
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('success', 'Kelas berhasil diubah.');
        }else{
            return redirect()
                ->route('kelas.show', $kelas)
                ->with('error', 'Kelas gagal diubah.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        DB::beginTransaction();

        try{
            $kelas->delete();

            DB::commit();

            return redirect()
                ->route('kelas.index')
                ->with('success', 'Kelas berhasil dihapus.');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Kelas gagal dihapus. Masih ada data siswa yang ter-relasi dengan data ini.');
        }
    }

    public function json(){

        if(\Roles::has('Super Admin')){
            $data = Kelas::orderBy('created_at','DESC')->get();
        }else{
            $user_id = auth()->user()->id;
            $data = Kelas::where( ['user_id' => $user_id] )
                ->orderBy('created_at','DESC')
                ->get();
        }

        return datatables()
                ->of($data)
                ->addColumn('kelas',function($data){
                    return $data->getKelas();
                })
                ->addColumn('prefix',function($data){
                    return $data->getPrefix();
                })
                ->editColumn('jurusan',function($data){
                    return $data->jurusan->nama;
                })
                ->addColumn('akumulasi_point_pelanggaran',function($data) {
                    return $data->getTotalPoint( 'point_pelanggaran',$data->id );
                })
                ->addColumn('akumulasi_point_penghargaan',function($data) {
                    return $data->getTotalPoint( 'point_penghargaan',$data->id );
                })
                ->removeColumn([
                    'kelas_x',
                    'kelas_xi',
                    'kelas_xii',
                    'updated_at',
                    'created_at'
                ])
                ->addColumn('action',function($data){
                    $routeEdit = route('kelas.edit', $data);
                    $routeDetail = route('kelas.show', $data);
                    $routeDestroy = route('kelas.destroy', $data);

                    $token = csrf_token();
                    $method = "<input type='hidden' name='_method' value='delete'>";
                    $csrf = "<input type='hidden' name='_token' value='$token'>";

                    $buttonEdit = "
                            <a href='$routeEdit' class='btn btn-primary mb-1 mr-1'>
                                <i class='fa fa-pencil-alt'></i> Ubah
                            </a>";
                    
                    $buttonDetail = "
                            <a href='$routeDetail' class='btn btn-warning mb-1 mr-1'>
                                <span class='fas fa-eye'></span> Detail
                            </a>";

                    $buttonDestroy = "
                            <form action='$routeDestroy' class='d-inline-block' method='post'>
                                $csrf
                                $method
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <span class='fa fa-trash-alt'></span> Hapus
                                </button>
                            </form>";


                    if(\Roles::has('Super Admin')){
                        $button = "$buttonEdit $buttonDetail $buttonDestroy";
                    }else{
                        $button = "$buttonDetail";
                    }

                    return $button;
                })
                ->make(true);
    }

    public function guru(Request $request){
        $search = $request->search;

        $guru = User::whereIn('id',function($q) {
            $q->select('user_roles.user_id')
                ->from('user_roles')
                ->whereColumn('user_roles.user_id','users.id')
                ->join('roles','user_roles.role_id','=','roles.id')
                ->whereNotIn('user_id',function($q2){
                    $q2->select('user_roles.user_id')
                        ->from('user_roles')
                        ->join('kelas', 'kelas.user_id', 'user_roles.user_id');
                })
                ->where(['roles.nama' => 'Wali Kelas']);
        });

        if($search != ''){
            $guru = $guru->where('name','like',"%$search%")->limit(6)->get();
        }else{
            $guru = $guru->limit(6)->get();
        }

        $response = [];
        $selected = (int)$request->selected;

        foreach($guru as $row){
            if($selected == $row->id):
                array_push($response,[
                    'id' => $row->id,
                    'text' => $row->name,
                    'selected' => true,
                ]);
            else:
                array_push($response,[
                    'id' => $row->id,
                    'text' => $row->name
                ]);
            endif;
        }

        return response()->json($response);
    }

}
