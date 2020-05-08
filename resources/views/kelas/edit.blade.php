@extends('layouts.main')

@push('title', 'Ubah Kelas')
@push('header-title', 'Ubah Kelas')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('kelas.update', $kelas) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" disabled>
                        <option value="">{{ $kelas->tahun_ajaran }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan_id" id="jurusan" class="form-control" disabled>
                        <option value="">{{ $kelas->jurusan->nama }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control" disabled>
                        <option value="">{{ $kelas->getKelas() }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <select name="grade" id="grade" class="form-control" disabled>
                        <option value="">{{ $kelas->grade }}</option>
                    </select>
                </div>
                <div class="form-group w-100">
                    <label for="guru">Wali Kelas</label>
                    <span class="d-block mb-1">Guru saat ini : <strong>{{ $kelas->user->name }}</strong></span>
                    <select name="walikelas" id="guru" class="form-control select2bs4">
                        <option value="">-- Pilih Wali Kelas --</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="btn-submit">
                        Submit
                    </button>
                    <a href="{{ route('kelas.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $("#guru").select2({
            ajax: {
                url: "{{route('select2.kelas.guru')}}",
                type: "post",
                dataType: 'json',
                delay: 10,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        selected: "{{ $kelas->user_id }}",
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        })

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
