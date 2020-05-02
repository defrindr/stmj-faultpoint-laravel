@extends('layouts.main')


@push('title')
	Detail Siswa
@endpush
@push('header-title')
	Detail Siswa
@endpush


@section('content')
<div class="col-md-12">
  <x-alerts :data="$errors" />
  <div class="card card-danger">
    <div class="card-header">
        <a href="{{ route('kelas.show',['kelas' => $kelas]) }}" class="btn btn-danger">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-hover">
            <tr>
                <th>NIP</th><td>{{ $siswa->nip }}</td>
            </tr>
            <tr>
                <th>Nama</th><td>{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <th>TTL</th><td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Alamat</th><td>{{ $siswa->alamat_rumah }}</td>
            </tr>
            <tr>
                <th>Domisili</th><td>{{ $siswa->alamat_domisili }}</td>
            </tr>
            <tr>
                <th>No Telp</th><td>{{ $siswa->no_telp }}</td>
            </tr>
            <tr>
                <th>Nama Wali</th><td>{{ $siswa->nama_wali }}</td>
            </tr>
            <tr>
                <th>No Telp Wali</th><td>{{ $siswa->no_telp_wali }}</td>
            </tr>
        </table>
    </div>
  </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <h3>Riwayat Penghargaan : <strong>{{ $siswa->point_penghargaan }}</strong> Point</h3>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-body">
            <h3>Riwayat Pelanggaran : <strong>{{ $siswa->point_pelanggaran }}</strong> Point</h3>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>

</script>
@endpush