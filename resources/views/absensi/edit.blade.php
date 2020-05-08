@extends('layouts.main')

@push('title', 'Ubah Absensi Kelas')
@push('header-title', 'Ubah Absensi Kelas')

@section('content')
<div class="col-md-6">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form id="form_ajax" class="form">
                @csrf
                <div class="form-group">
                    <label for="tanggal_ajax">Tanggal</label>
                    <input type="date" name="tanggal_ajax" id="tanggal_ajax" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nip_ajax">Siswa</label>
                    <select id="nip_ajax"" name="nip_ajax" class="form-control">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswa as $nip => $nama)
                            <option value="{{ $nip }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success mb-1 mr-1" onclick="cariData(event)">Cari Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('absensi.update', $kelas) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id">
                <input type="hidden" class="form-control" id="siswa_nip" name="siswa_nip">
                <div class="form-group">
                    <label for="siswa_nama">Siswa</label>
                    <input type="text" class="form-control" id="siswa_nama" name="siswa_nama" readonly>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        @foreach ($status as $item)
                            <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" readonly>
                </div>
                <div class="form-group">
                    <button class="btn btn-success mb-1 mr-1" id="btn-submit">Submit</button>
                    <a href="{{ route('absensi.show-kelas',$kelas) }}" class="btn btn-danger mb-1 mr-1">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    let CSRF_TOKEN = $('meta[name=csrf-token]').attr('content');

    let cariData = (e) => {
        e.preventDefault();

        let tanggal = $('#tanggal_ajax').val();
        let nip = $('#nip_ajax').val();

        $.ajax({
            url: `{{ route("absensi.edit.get-data",$kelas) }}`,
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: CSRF_TOKEN,
                tanggal: tanggal,
                nip: nip,
            }
        }).done( (resp) => {
            if(resp.success){
                $('#id').val(resp.data.id);
                $('#siswa_nip').val(resp.data.siswa_nip);
                $('#keterangan').val(resp.data.keterangan);
                $('#siswa_nama').val(resp.data.siswa_nama);

                let target = document.querySelectorAll(`#status>option[value=${resp.data.status}]`);

                let already = $('#status').find('option:selected');
                if(already !== undefined){
                    already.removeAttr('selected');
                }

                target[0].setAttribute('selected', '');

                $('#keterangan').removeAttr('readonly');
            }else{
                Swal.fire({
                    title: 'Data tidak ditemukan !'
                });
            }
        });
    }

    $('#btn-submit').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data di dalam database akan diubah setelah proses ini dijalankan.",
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
