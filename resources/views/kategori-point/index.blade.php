@extends('layouts.main')

@push('title','Kategori Point')
@push('header-title','Daftar Kategori Point')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-header">
            <a href="{{ route('kategori-point.create') }}" class="btn btn-success">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-borderless" id="kategori-point-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Point</th>
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('_js')
<script>
$(function() {
    $('#kategori-point-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("datatables.kategori-point") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama', name: 'nama' },
            { data: 'jenis_point', name: 'jenis_point' },
            { data: 'action', name: 'action' },
        ],
        drawCallback: function(settings){
            $('.deleteAlerts').on('click', function(e) {
                e.preventDefault();
                let form = $(this).parents('form');
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Data akan dihapus secara permanen dari database setelah proses ini dijalankan.",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya!",
                    cancelButtonText: 'Tidak',
                }).then( (result) =>{
                    if(result.value) $(form).submit();
                })
            });
        }
    });
});

</script>
@endpush

