<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Role;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Requests\KelasRequest;

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
        $startYear = ((int) date('Y'));
        $endYear = ((int) date('Y')) + 6;
        while($startYear < $endYear){
            $schema = $startYear. "/". ($startYear+1);
            array_push($tahun,$schema);
            $startYear += 1;
        }

        $jurusan = Jurusan::select(['id','nama'])->get();

        return view('kelas.create',[
            'tahun' => $tahun,
            'jurusan' => $jurusan
        ]);
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
            return redirect()->route('kelas.show',[
                'kelas'=>$kelas])->with('success','Kelas berhasil dibuat');
        }else{
            return redirect()->route('kelas.create')->with('error','Kelas gagal dibuat');
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
        return view('kelas.show',[
            'kelas' => $kelas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {

        $jurusan = Jurusan::select(['id','nama'])->get();

        return view('kelas.edit',[
            'kelas' => $kelas,
        ]);
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
            return redirect()->route('kelas.show',[
                'kelas' => $kelas
            ])->with('success','Kelas berhasil diubah');
        }else{
            return redirect()->route('kelas.show',[
                'kelas' => $kelas
            ])->with('error','Kelas gagal diubah');
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
        try{
            if($kelas->delete()){
                return redirect()->route('kelas.index')->with('success','Kelas berhasil dihapus');
            }else{
                return redirect()->route('kelas.index')->with('error','Kelas gagal dihapus');
            }
        }catch(\Exception $e){
            return redirect()->route('kelas.index')->with('error','Kelas gagal dihapus. Terdapat anak dari data ini.');
        }
    }

    public function json(){

        $data = Kelas::all();

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
                ->removeColumn(['kelas_x','kelas_xi','kelas_xii'])
                ->addColumn('action',function($data){
                    $routeEdit = route('kelas.edit',['kelas' => $data]);
                    $routeShow = route('kelas.show',['kelas' => $data]);
                    $routeDelete = route('kelas.destroy',['kelas' => $data]);
                    $token = csrf_token();

                    $button = "
                            <a  href='$routeEdit' class='btn btn-primary mb-1 mr-1'>
                                <span class='fa fa-pencil-alt'></span> Ubah
                            </a>
                            <a  href='$routeShow' class='btn btn-warning mb-1 mr-1'>
                                <span class='fas fa-eye'></span> Detail
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

    public function guru(Request $request){
        $search = $request->search;

        $guru = User::whereIn('id',function($q) {
            $q->select('user_id')
                ->from('user_roles')
                ->whereColumn('user_id','users.id')
                ->join('roles','user_roles.role_id','=','roles.id')
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
