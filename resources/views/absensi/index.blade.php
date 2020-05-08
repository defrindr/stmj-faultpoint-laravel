@extends('layouts.main')

@push('title', 'Daftar Absensi Kelas')
@push('header-title', 'Daftar Absensi Kelas')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table class="table table-striped table-borderless w-100" id="table-absensi">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Absen Hari Ini</th>
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
        $('#table-absensi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("datatables.absensi") }}',
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
                    data: 'status_absen_hari_ini',
                    name: 'status_absen_hari_ini'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
        });
    });

</script>
@endpush
