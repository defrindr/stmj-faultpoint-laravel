@extends('layouts.main')

@push('title','Ubah Hari Efektif')
@push('header-title','Ubah Hari Efektif')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-default">
        <div class="card-body">
            <form method="post" action="{{ route('hari-tidak-efektif.update', $hariTidakEfektif->id)  }}" class="form">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" placeholder="Masukkan Tanggal" name="tanggal"
                        value="{{ CStr::date($hariTidakEfektif->tanggal) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="">-- Pilih Status --</option>
                        @foreach ($status as $key => $val)
                        <option value="{{ $key }}" @if($hariTidakEfektif->status == $key) selected @endif
                            >{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea type="text" class="form-control" id="keterangan" placeholder="Masukkan keterangan"
                        name="keterangan">{{ $hariTidakEfektif->keterangan }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success mr-1 mb-1" id="btn-submit">Submit</button>
                    <a href="{{ route('hari-tidak-efektif.index') }}" class="btn btn-danger mr-1 mb-1">Kembali</a>
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
            text: "Data dalam database akan diubah setelah proses ini dijalankan.",
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
