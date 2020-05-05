@extends('layouts.main')

@push('title','Ubah Point')
@push('header-title','Ubah Point')

@section('content')

<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-default">
        <div class="card-body">
            <form method="post" action="{{ route('kategori-point.show.update',[$kategoriPoint,$point]) }}" class="form">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="kategori_peraturan" class="mt-3">Kategori Peraturan</label>
                    <input type="text" class="form-control" id="kategori_peraturan" name="kategori_peraturan"
                        value="{{ $kategoriPoint->nama }}" disabled>
                </div>
                <div class="form-group">
                    <label for="peraturan" class="mt-3">Peraturan</label>
                    <input type="text" class="form-control" id="peraturan" placeholder="Masukkan peraturan"
                        name="peraturan" value="{{ $point->peraturan }}">
                </div>
                <div class="form-group">
                    <label for="interval_waktu" class="mt-3">Interval Waktu</label>
                    <input type="number" class="form-control" id="interval_waktu" placeholder="Masukkan interval_waktu"
                        name="interval_waktu" value="{{ $point->interval_waktu }}">
                </div>
                <div class="form-group">
                    <label for="point" class="mt-3">Point</label>
                    <input type="number" class="form-control" id="point" placeholder="Masukkan point" name="point"
                        value="{{ $point->point }}">
                </div>
                <div class="form-group">
                    <label for="sanksi" class="mt-3">Sanksi</label>
                    <input type="text" class="form-control" id="sanksi" placeholder="Masukkan sanksi" name="sanksi"
                        value="{{ $point->sanksi }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success mb-1 mr-1" id="btn-submit">Submit</button>
                    <a href="{{ route('kategori-point.show', $kategoriPoint) }}"
                        class="btn btn-danger mb-1 mr-1">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('_js')
<script>
    $('#btn-submit').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data akan diubah setelah proses ini dijalankan.",
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
