@extends('layouts.main')

@push('title', 'Tambah Jurusan')
@push('header-title', 'Tambah Jurusan')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('jurusan.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="nama" id="name">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="btn-submit">
                        Submit
                    </button>
                    <a href="{{ route('jurusan.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $('#btn-submit').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data akan ditambahkan ke dalam database setelah proses ini dijalankan.",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) form.submit();
        });
    });

</script>
@endpush
