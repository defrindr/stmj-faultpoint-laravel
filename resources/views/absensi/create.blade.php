@extends('layouts.main')

@push('title', 'Tambah Absensi Kelas')
@push('header-title', 'Tambah Absensi Kelas')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <form action="{{ route('absensi.store', $kelas) }}" method="POST" class="form">
                @csrf
                <div class="form-group" id="row_container">
                </div>
                <div class="form-group">
                    <a href="#" class="btn btn-primary mb-1 mr-1" onclick="addRow(event)">Tambah Kolom</a>
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
    let i = 0;
    let target = document.querySelector('#row_container');
    let listRow = [];
    let getSchema = () => {
        listRow.push(`#row${i}`);

        let schema = `
            <div class="row mb-3" id="row${i}">
                <div class="col-sm-3 d-sm-flex d-block">
                    <strong class="mr-1">#${i+1}</strong>
                    <select name="siswa_nip[]" class="form-control mb-2" id="siswa_nip${i}">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $nip => $nama)
                        <option value="{{ $nip }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="status[]" class="form-control mb-2" id="status${i}">
                        <option value="">-- Pilih Status --</option>
                        @foreach($status as $val)
                        <option value="{{ $val }}">{{ strtoupper($val) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                        <textarea name="keterangan[]" class="form-control mb-2" id="keterangan${i}" placeholder="Keterangan"></textarea>
                </div>
                <div class="col-sm-2">
                    <a href="#" class="btn btn-danger mb-2" onclick="deleteRow(event,'#row${i}')">Delete</a>
                </div>
            </div>`;

        schema = new DOMParser().parseFromString(schema,'text/html').body;

        schema = schema.querySelector('div');

        i++;
        
        return schema;
    }
    let addRow = (e) => {
        if(e !== undefined) e.preventDefault();
        let schema = getSchema();
        target.appendChild(schema);
    }
    let deleteRow = (e,id) => {
        e.preventDefault();
        let deletedRow = document.querySelector(id);

        listRow.splice(listRow.indexOf(id),1);

        deletedRow.remove();

    }

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
    addRow();
</script>
@endpush
