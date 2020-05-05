@extends('layouts.main')

@push('title', 'Daftar Jurusan')
@push('header-title', 'Menu Jurusan')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('jurusan.create') }}" class="btn btn-success mr-1 mb-1">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-borderless w-100" id="hari-efektif-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(function () {
        $('#hari-efektif-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("datatables.jurusan") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama',
                    name: 'nama'
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
                        text: "Data akan ditambahkan ke dalam database setelah proses ini dijalankan.",
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
