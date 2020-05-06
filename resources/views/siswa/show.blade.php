@extends('layouts.main')

@push('title', 'Detail Siswa')
@push('header-title', 'Detail Siswa')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-danger">
        <div class="card-header">
            <a href="{{ route('kelas.show', $kelas) }}" class="btn btn-danger">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-borderless table-hover">
                <tr>
                    <th>NIP</th>
                    <td>{{ $siswa->nip }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <th>TTL</th>
                    <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $siswa->alamat_rumah }}</td>
                </tr>
                <tr>
                    <th>Domisili</th>
                    <td>{{ $siswa->alamat_domisili }}</td>
                </tr>
                <tr>
                    <th>No Telp</th>
                    <td>{{ $siswa->no_telp }}</td>
                </tr>
                <tr>
                    <th>Nama Wali</th>
                    <td>{{ $siswa->nama_wali }}</td>
                </tr>
                <tr>
                    <th>No Telp Wali</th>
                    <td>{{ $siswa->no_telp_wali }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3>Riwayat Penghargaan : <strong>{{ $siswa->point_penghargaan }}</strong> Point</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless w-100" id="table-penghargaan">
                <thead>
                    <th>Tanggal</th>
                    <th>Kasus</th>
                    <th>Point</th>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3>Riwayat Pelanggaran : <strong>{{ $siswa->point_pelanggaran }}</strong> Point</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless w-100" id="table-pelanggaran">
                <thead>
                    <th>Tanggal</th>
                    <th>Kasus</th>
                    <th>Point</th>
                </thead>
            </table>

        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(function () {
        $('#table-penghargaan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('datatables.kelas.show.siswa.penghargaan', [$kelas, $siswa] ) }}",
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'peraturan',
                    name: 'peraturan'
                },
                {
                    data: 'point',
                    name: 'point'
                },
            ],
        });
        $('#table-pelanggaran').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('datatables.kelas.show.siswa.pelanggaran', [$kelas, $siswa] ) }}",
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'peraturan',
                    name: 'peraturan'
                },
                {
                    data: 'point',
                    name: 'point'
                },
            ],
        });
    });

</script>
@endpush
