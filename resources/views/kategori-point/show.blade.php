@extends('layouts.main')

@push('title','Detail Kategori Point')
@push('header-title','Detail Kategori Point')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-danger">
        <div class="card-header">
            <a href="{{ route('kategori-point.index') }}" class="btn btn-danger mb-2 mr-1">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-stripped">
                <tr>
                    <th>Nama</th>
                    <td>{{ $kategoriPoint->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Point</th>
                    <td>{{ $kategoriPoint->getJenisPoint() }}</td>
                </tr>
                <tr>
                    <th>Jumlah Point</th>
                    <td>{{ count($kategoriPoint->point) }} Data</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('kategori-point.show.create',$kategoriPoint) }}" class="btn btn-success mb-1 mr-1">Tambah
                Point</a>
        </div>
        <div class="card-body">
            <table id="table-point" class="table table-hover table-stripped table-borderless w-100">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Peraturan</th>
                    <th scope="col">Point</th>
                    <th scope="col">Interval waktu (Berturut-turut)</th>
                    <th scope="col">Sanksi</th>
                    <th scope="col">Action</th>
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
            $('#table-point').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('datatables.kategori-point.show.point',$kategoriPoint) }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'peraturan',
                        name: 'peraturan'
                    },
                    {
                        data: 'point',
                        name: 'point'
                    },
                    {
                        data: 'interval_waktu',
                        name: 'interval_waktu'
                    },
                    {
                        data: 'sanksi',
                        name: 'sanksi'
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
