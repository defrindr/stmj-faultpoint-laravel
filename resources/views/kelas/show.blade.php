@extends('layouts.main')

@push('title', 'Detail Kelas')
@push('header-title', 'Detail Kelas')

@section('content')
<div class="col-md-6">
    <x-alerts :data="$errors" />
    <div class="card card-danger">
        <div class="card-header">
            <a href="{{ route('kelas.index') }}" class="btn btn-danger mb-2 mr-1">Kembali</a>
            @if (Roles::has('Super Admin'))
            <a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-primary mb-2 mr-1">Ubah</a>
            @endif
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

<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3>3 Kasus Terakhir</h3>
        </div>
        <div class="card-body">
            <table class="table table-borderless table-hover">
                <thead>
                    <th>Nama</th>
                    <th>kasus</th>
                    <th>Tanggal Kejadian</th>
                </thead>
                <tbody>
                    @if (count($kasus) > 0)
                    @foreach ($kasus as $item)
                        <tr>
                            <td>{{ $item->siswa->nama }}</td>
                            <td>{{ $item->point->peraturan }}</td>
                            <td>{{ CStr::date($item->tanggal) }}</td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Data tidak ditemukan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
            @if (Roles::has('Super Admin'))
            <a href="{{ route('siswa.create', $kelas) }}" class="btn btn-success mb-1 mr-1">Tambah Siswa</a>
            @endif
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
                ajax: "{{ route('datatables.kelas.show.siswa', $kelas) }}",
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
                ],
                drawCallback: function (settings) {
                    $('.deleteAlerts').on('click', function (e) {
                        e.preventDefault();
                        let form = $(this).parents('form');
                        Swal.fire({
                            title: "Apakah anda yakin?",
                            text: "Data akan dihapus secara permanen dari database setelah proses ini dijalankan.",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ya!",
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.value) $(form).submit();
                        });
                    });
                }
            });
        });
    });

</script>
@endpush
