@extends('layouts.main')

@push('title', 'Daftar Kelas')
@push('header-title', 'Daftar Kelas')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
            @if (Roles::has('Super Admin'))
                <a href="{{ route('kelas.create') }}" class="btn btn-success mr-1 mb-1">Tambah</a>
            @endif
        </div>
        <div class="card-body">
            <table class="table table-striped table-borderless w-100" id="kelas-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Prefix</th>
                        <th>Tahun Ajaran</th>
                        <th>Penghargaan</th>
                        <th>Pelanggaran</th>
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
            ajax: '{{ route("datatables.kelas") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'prefix',
                    name: 'prefix'
                },
                {
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran'
                },
                {
                    data: 'akumulasi_point_penghargaan',
                    name: 'akumulasi_point_penghargaan'
                },
                {
                    data: 'akumulasi_point_pelanggaran',
                    name: 'akumulasi_point_pelanggaran'
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
                    })
                });
            }
        });
    });

</script>
@endpush
