@extends('layouts.main')

@push('title','Daftar Hari Tidak Efektif')
@push('header-title','Hari Tidak Efektif')

@section('content')
<div class="col-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('hari-tidak-efektif.create') }}" class="btn btn-success">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless" id="hari-tidak-efektif-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Action</th>
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
        $('#hari-tidak-efektif-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("datatables.hari-tidak-efektif") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
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
