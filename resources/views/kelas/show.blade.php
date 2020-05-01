@extends('layouts.main')


@push('title')
Detail Kelas
@endpush
@push('header-title')
Detail Kelas
@endpush

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-default">
        <div class="card-header">
            <a href="{{ route('kelas.index') }}" class="btn btn-danger mb-2 mr-1">Kembali</a>
            <a href="{{ route('kelas.edit',['kelas' => $kelas]) }}" class="btn btn-primary mb-2 mr-1">Ubah</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-stripped">
                <tr>
                    <th>Prefix</th>
                    <td>{{ $kelas->getPrefix() }}</td>
                </tr>
                <tr>
                    <th>Tahun Ajaran</th>
                    <td>{{ $kelas->tahun_ajaran }}</td>
                </tr>
                <tr>
                    <th>Jumlah Siswa</th>
                    <td>{{ count($kelas->siswa) }} Siswa</td>
                </tr>
                <tr>
                    <th>Wali Kelas</th>
                    <td>{{ $kelas->user->name }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('siswa.create') }}" class="btn btn-success mb-1 mr-1">Tambah Siswa</a>
        </div>
        <div class="card-body">
            <table id="table-siswa" class="table table-hover table-stripped table-borderless w-100">
                <thead>
                    <th>NIP</th>
                    <th>Nama Siswa</th>
                    <th>Point Pelanggaran</th>
                    <th>Point Penghargaan</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(function () {
        $(document).ready(function () {
            $('#table-siswa').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('datatables.kelas.show.siswa',['kelas' => $kelas]) }}",
                columns: [{
                        data: 'nip',
                        name: 'nip'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'point_pelanggaran',
                        name: 'point_pelanggaran'
                    },
                    {
                        data: 'point_penghargaan',
                        name: 'point_penghargaan'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            })
        });
    })

</script>
@endpush
