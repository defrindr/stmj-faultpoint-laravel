@extends('layouts.main')

@push('title', 'Ubah Kasus')
@push('header-title', 'Ubah Kasus')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('kasus.update',$kasus) }}" method="post" class="form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kelas_id">Kelas</label>
                    <input type="text" name="kelas_id" id="kelas_id" class="form-control select2bs4"
                        value="{{ $kasus->siswa->kelas->getPrefix() }}" readonly>
                </div>
                <div class="form-group">
                    <label for="siswa_nip">Siswa</label>
                    <input type="text" name="siswa_nip" id="siswa_nip" class="form-control select2bs4"
                        value="{{ $kasus->siswa->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label for="kategori_point_id">Kategori Kasus</label>
                    <input type="text" name="kategori_point_id" id="kategori_point_id" class="form-control select2bs4"
                        value="{{ $kasus->point->kategori_point->nama. " (". strtoupper($kasus->point->kategori_point->jenis_point). ")" }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="point_id">Kasus</label>
                    <input type="text" name="point_id" id="point_id" class="form-control select2bs4"
                        value="{{ $kasus->point->peraturan }}" readonly>
                </div>
                <div class="form-group">
                    <label for="point">Point</label>
                    <input type="text" name="point" id="point" class="form-control"
                        value="{{ $kasus->point->point. " Point" }}" disabled>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        value="{{ date('Y-m-d', strtotime($kasus->tanggal)) }}" max="{{ $today }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-success mb-1 mr-1" id="btn-submit">Submit</button>
                    <a href="{{ route('kasus.index') }}" class="btn btn-danger mb-1 mr-1">Kembali</a>
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
        $('#btn-submit').on('click', function (e) {
            e.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Data didalam database akan diubah setelah proses ini dijalankan.",
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
