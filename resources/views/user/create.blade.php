@extends('layouts.main')

@push('title','Tambah User')
@push('header-title','Tambah User')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="name">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Possword Confirm <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                    <div class="text-danger" id="passwordNotMatch"></div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="btn-submit">
                        Submit
                    </button>
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(document).ready(function () {
        function checkPw() {
            if ($('input[name=password]').val() !== $('input[name=password_confirm]').val()) {
                $('#passwordNotMatch').html("Password tidak sama");
            } else {
                $('#passwordNotMatch').html("");
            }
        }

        $('input[name=password]').on('keyup', () => {
            checkPw();
        });

        $('input[name=password_confirm]').on('keyup', () => {
            checkPw();
        });

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
