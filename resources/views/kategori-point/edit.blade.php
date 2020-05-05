@extends('layouts.main')

@push('title', 'Ubah Kategori Point')
@push('header-title', 'Ubah Kategori Point')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-default">
        <div class="card-header">
            <form method="post" action="{{ route('kategori-point.update', $kategoriPoint->id) }}">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="nama"">Nama</label>
                    <input type=" text" class="form-control" id="nama" placeholder="Masukkan nama" name="nama"
                        value="{{ $kategoriPoint->nama }}">
                </div>
                <div class="form-group">
                    <label for="jenis_point"">Jenis Point</label>
                    <select name=" jenis_point" class="form-control" id="jenis_point" name="jenis_point">
                        <option value="">-- Pilih Jenis Point --</option>
                        @foreach ($jenisPoint as $val)
                        <option value="{{ $val }}" @if($val==$kategoriPoint->jenis_point) selected @endif
                            >{{ strtoupper($val) }}</option>
                        @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success mb-1 mr-1" id="btn-submit">Submit</button>
                    <a href="{{ route('kategori-point.index') }}" class="btn btn-danger mb-1 mr-1">Kembali</a>
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
