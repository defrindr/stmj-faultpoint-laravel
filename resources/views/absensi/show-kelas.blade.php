@extends('layouts.main')

@push('title', 'Detail Kelas')
@push('header-title', 'Detail Kelas')
@push('_css')
<style>
    #advanced-filter{
        display: none;
    }
</style>
@endpush

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-danger">
        <div class="card-header">
            <a href="{{ route('absensi.index') }}" class="btn btn-danger mb-2 mr-1">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-stripped">
                <tr>
                    <th>Kelas</th>
                    <td>{{ $kelas->getPrefix() }}</td>
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
    <div class="card card-primary">
        <div class="card-header">
            <a href="{{ route('absensi.create', $kelas) }}" class="btn btn-primary mb-1 mr-1">Tambah Absen Hari Ini</a>
            @if (Roles::has('Super Admin'))
                <a href="{{ route('absensi.edit', $kelas) }}" class="btn btn-primary mb-1 mr-1">Ubah Data</a>
            @endif
            <button class="btn btn-primary mb-1 mr-1" onclick="showAdvSearch()">Advanced Filter</button>
        </div>
        <div class="card-body">
            <form id="advanced-filter" class="form mb-2 pb-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" onclick="searchData(event)">Cari Data</button>
                </div>
            </form>
            <table id="table-siswa" class="table table-hover table-stripped table-borderless w-100">
                <thead>
                    <th>NIP</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    let dtTable = $('#table-siswa').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: `{{ route('datatables.absensi.siswa', $kelas) }}`,
                    data: function(d){
                        d.tanggal= $('#tanggal').val();
                    }
                },
                columns: [{
                        data: 'nip',
                        name: 'nip'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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

    let searchData = (e) => {
        e.preventDefault();

        dtTable.draw();    
    }

    let showAdvSearch = () => {
        let target = document.querySelector('#advanced-filter');
        let checkAttr = target.hasAttribute('style');

        if(checkAttr){
            target.removeAttribute('style')
        }else{
            target.setAttribute('style','display: block');
        }
    }

</script>
@endpush
