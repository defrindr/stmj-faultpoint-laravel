@extends('layouts.main')

@push('title','Daftar User')
@push('header-title','Menu User')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('user.create') }}" class="btn btn-success mr-1 mb-1">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-borderless w-100" id="kelas-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jumlah Roles</th>
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
        $('#kelas-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("datatables.user") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
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
                        title: "Peringatan",
                        text: "Apakah anda yakin akan menjalankan aksi ini ?",
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
