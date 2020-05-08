<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\HariEfektif;
use App\Models\HariTidakEfektif;
use App\Http\Requests\AbsensiRequest;
use Illuminate\Http\Request;
use DB;

class AbsensiController extends Controller
{
    public function getDayNow(){
        $today = date('D');
        $days = [
            'Sun' => "Minggu",
            'Mon' => "Senin",
            'Tue' => "Selasa",
            'Wed' => "Rabu",
            'Thu' => "Kamis",
            'Fri' => "Jum'at",
            'Sat' => "Sabtu",
        ];
     
        return $days[$today];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('absensi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kelas $kelas)
    {
        $prefixKelas = $kelas->getPrefix();
        $today = date('Y-m-d');
        $daynow = $this->getDayNow();
        $hariTidakEfektf = HariTidakEfektif::where( ['tanggal' => $today] )
            ->first();
        $hariEfektif = HariEfektif::where( ['hari' => $daynow] )
            ->first();
        $absenHariIni = Absensi::join('siswa', 'siswa.nip', 'siswa_nip')
            ->join('kelas', 'kelas.id', 'kelas_id')
            ->where( ['tanggal' => $today, 'kelas.id' => $kelas->id] )
            ->get();
        
        // dependensi
        $status = ["alpha", "ijin", "sakit", "bolos"];
        $siswaDB = Siswa::where( ['kelas_id' => $kelas->id] )
            ->orderBy('nama','ASC')
            ->get();

        $siswa = [];
        foreach($siswaDB as $row){
            $siswa += [$row->nip => $row->nama];
        }

        if($hariTidakEfektf){
            return redirect()
                ->route('absensi.show-kelas', $kelas)
                ->with('error', "Hari ini libur dikarenakan $hariTidakEfektf->keterangan");
        }else{
            if($hariEfektif->status){
                if( count($absenHariIni) > 0){
                    return redirect()
                        ->route('absensi.show-kelas', $kelas)
                        ->with('error', "Kelas $prefixKelas Hari ini telah diabsen.");
                }else{
                    return view('absensi.create', compact('kelas', 'status', 'siswa'));
                }
                
            }else{
                return redirect()
                    ->route('absensi.show-kelas', $kelas)
                    ->with('error', "$hariEfektif->hari bukan hari efektif");
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsensiRequest $request,Kelas $kelas)
    {
        $today = date('Y-m-d');
        $user = auth()->user()->id;
        $countData = count($request->siswa_nip);
        $nips = [];

        foreach($request->siswa_nip as $row){
            array_push($nips,$row);
        }
        
        $siswaHadir = Siswa::whereNotIn('nip',$nips)
            ->get();

        DB::beginTransaction();

        try{
            // Insert Siswa Hadir
            foreach($siswaHadir as $row){
                $schema = [
                    'tanggal' => $today,
                    'status' => 'hadir',
                    'keterangan' => '-',
                    'siswa_nip' => $row->nip,
                    'user_id' => $user
                ];
                $absensi = new Absensi($schema);
                $absensi->save();
            }
            // Insert Siswa Tidak Hadir
            for($i=0;$i<$countData;$i++){
                $schema = [
                    'tanggal' => $today,
                    'status' => $request->status[$i],
                    'keterangan' => $request->keterangan[$i],
                    'siswa_nip' => $request->siswa_nip[$i],
                    'user_id' => $user
                ];
                $absensi = new Absensi($schema);
                $absensi->save();
            }
            DB::commit();
            return redirect()
                ->route('absensi.show-kelas', $kelas)
                ->with('success', 'Absensi berhasil ditambahkan.');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()
                ->route('absensi.show-kelas', $kelas)
                ->with('success', 'Gagal menambahkan absensi.');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        $status = ['alpha', 'ijin', 'sakit', 'bolos', 'hadir'];
        $siswaDB = Siswa::where( ['kelas_id' => $kelas->id] )
            ->orderBy('nama','ASC')
            ->get();

        $siswa = [];
        foreach($siswaDB as $row){
            $siswa += [$row->nip => $row->nama];
        }

        return view('absensi.edit' , compact('kelas', 'status', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(AbsensiRequest $request,Kelas $kelas)
    {
        $absensi = Absensi::where([
            'id' => $request->id, 
            'siswa_nip' => $request->siswa_nip
        ])->first();

        $schema = [
            "status" => $request->status,
            "keterangan" => $request->keterangan
        ];

        try{
            $absensi->update($schema);

            return redirect()
                ->route('absensi.show-kelas', $kelas)
                ->with('success', 'Absensi berhasil diubah');
        }catch(\Exception $e){
            return redirect()
                ->route('absensi.show-kelas', $kelas)
                ->with('error', 'Absensi gagal diubah');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }



    public function jsonSiswa(Request $request,Kelas $kelas){
        $tanggal = date('Y-m-d');

        if( $request->tanggal != "" ){
            $tanggal = $request->tanggal;
        }

        $data = Absensi::where([ 'tanggal' => $tanggal, 'kelas_id' => $kelas->id ])
            ->where('status','!=','hadir')
            ->join('siswa','siswa.nip','siswa_nip')
            ->join('kelas','kelas.id','kelas_id')
            ->select( ['siswa.nip', 'siswa.nama', 'tanggal', 'absensi.status', 'absensi.keterangan'] )
            ->get();

        return datatables()
            ->of($data)
            ->editColumn('tanggal',function($data) {
                return \CStr::date($data->tanggal);
            })
            ->editColumn('status',function($data) {
                return strtoupper($data->status);
            })
            ->make(true);
    }


    public function json(Request $request,Kelas $kelas){

        $data = Kelas::get();

        $today = date('Y-m-d');

        $kelasTelahAbsenHariIni = Absensi::join('siswa', 'siswa.nip', 'siswa_nip')
            ->join('kelas', 'kelas.id', 'kelas_id')
            ->join('jurusan', 'jurusan.id', 'jurusan_id')
            ->select('tanggal','kelas_id')
            ->groupBy('tanggal','kelas_id')
            ->having('tanggal',$today)
            ->get();

        $datatables = datatables()
                ->of($data,$kelasTelahAbsenHariIni)
                ->addColumn('prefix',function($data) {
                    return $data->getPrefix();
                })
                ->addColumn('status_absen_hari_ini',function($data) use($kelasTelahAbsenHariIni) {
                    $retString = "Belum Diabsen";
                    foreach($kelasTelahAbsenHariIni as $row){
                        if($data->id == $row->kelas_id){
                            $retString = "Sudah Diabsen";
                        }
                    }
                    return $retString;
                })
                ->removeColumn([
                    'grade',
                    'kelas_x',
                    'kelas_xi',
                    'kelas_xii',
                    'jurusan_id',
                    'user_id',
                    'created_at',
                    'updated_at',
                ])
                ->addColumn('action',function($data){
                    $routeDetail = route('absensi.show-kelas', $data);
                    
                    $buttonDetail = "
                            <a href='$routeDetail' class='btn btn-warning mb-1 mr-1'>
                                <span class='fas fa-eye'></span> Detail
                            </a>";

                    $button = "$buttonDetail";
                    return $button;
                })
                ->make(true);
        
        return $datatables;
    }


    public function showKelas(Kelas $kelas){
        return view('absensi.show-kelas', compact('kelas'));
    }

    public function getDataSiswa(Request $request,Kelas $kelas){
        
        $tanggal = $request->tanggal;
        $nip = $request->nip;

        $absensi = Absensi::join('siswa', 'siswa.nip', 'siswa_nip')
            ->where([
                'kelas_id' => $kelas->id, 
                'tanggal' => $tanggal, 
                'nip' => $nip
            ])
            ->first();
        
        $data = [];
        $success = false;
        
        if($absensi){
            $success = true;
            $data = [
                "id" => $absensi->id,
                "siswa_nip" => $absensi->siswa_nip,
                "siswa_nama" => $absensi->siswa->nama,
                "status" => $absensi->status,
                "keterangan" => $absensi->keterangan,
            ];
        }

        $resp = [
            "success" => $success,
            "data" => $data,
            "fetch_on" => date('Y-m-d H:i:s')
        ];

        return $resp;
    }
}
