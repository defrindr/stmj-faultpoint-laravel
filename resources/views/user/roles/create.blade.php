@extends('layouts.main')

@push('title', 'Tambah Role')
@push('header-title', 'Tambah Role')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('user.store-role', $user) }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="name">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="roles">Role <span class="text-danger">*</span></label>
                    <select type="text" name="roles" id="roles" class="form-control">
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="btn-submit">
                        Submit
                    </button>
                    <a href="{{ route('user.show', $user) }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(document).ready(function () {

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
    });

</script>
@endpush
