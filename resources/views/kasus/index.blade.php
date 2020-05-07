@extends('layouts.main')

@push('title', 'Daftar Kasus')
@push('header-title', 'Daftar Kasus')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors"/>
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('kasus.create') }}" class="btn btn-success">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless w-100" id="table-kasus">
                <thead>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Kategori Kasus</th>
                    <th>Kasus</th>
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
        $('#table-kasus').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('datatables.kasus') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'nama_siswa',
                    name: 'nama_siswa'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'kategori_kasus',
                    name: 'kategori_kasus'
                },
                {
                    data: 'kasus',
                    name: 'kasus'
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
                        text: "Data akan dihapus dari dalam database setelah proses ini dijalankan.",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya!",
                        cancelButtonText: 'Tidak',
                    }).then((result) => {
                        if (result.value) $(form).submit();
                    })
                });
            }
        });
    });

</script>
@endpush
