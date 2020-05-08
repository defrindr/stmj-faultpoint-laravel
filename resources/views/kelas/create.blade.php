@extends('layouts.main')

@push('title', 'Tambah Kelas')
@push('header-title', 'Tambah Kelas')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('kelas.store') }}" method="POST" class="form">
                @csrf
                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                        <option value="">-- Pilih Ajaran --</option>
                        @foreach ($tahun as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan_id" id="jurusan" class="form-control">
                        <option value="">-- Pilih Ajaran --</option>
                        @foreach ($jurusan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="x">Kelas X</option>
                        <option value="xi">Kelas XI</option>
                        <option value="xii">Kelas XII</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <select name="grade" id="grade" class="form-control">
                        <option value="">-- Pilih Grade --</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="guru">Wali Kelas</label>
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
