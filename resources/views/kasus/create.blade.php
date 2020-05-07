@extends('layouts.main')

@push('title', 'Tambah Kasus')
@push('header-title', 'Tambah Kasus')

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors"/>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-body">
                    <form action="{{ route('kasus.store') }}" method="post" class="form">
                        @csrf
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control select2bs4">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siswa_nip">Siswa</label>
                            <select name="siswa_nip" id="siswa_nip" class="form-control select2bs4" readonly>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori_point_id">Kategori Kasus</label>
                            <select name="kategori_point_id" id="kategori_point_id" class="form-control select2bs4">
                                <option value="">-- Pilih Kategori Kasus --</option>
                                @foreach ($kategoriPoint as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="point_id">Kasus</label>
                            <select name="point_id" id="point_id" class="form-control select2bs4" readonly></select>
                        </div>
                        <div class="form-group">
                            <label for="point">Point</label>
                            <input type="text" name="point" id="point" class="form-control" value="0" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" max="{{ $today }}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success mb-1 mr-1" id="btn-submit">Submit</button>
                            <a href="{{ route('kasus.index') }}" class="btn btn-danger mb-1 mr-1">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-danger">
                        <div class="card-body">
                            <table class="table table-hover table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td id="siswa_nama">-</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td id="siswa_kelas">-</td>
                                    </tr>
                                    <tr>
                                        <th>Point Penghargaan</th>
                                        <td id="siswa_point_penghargaan">-</td>
                                    </tr>
                                    <tr>
                                        <th>Point Pelanggaran</th>
                                        <td id="siswa_point_pelanggaran">-</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Wali</th>
                                        <td id="siswa_nama_wali">-</td>
                                    </tr>
                                    <tr>
                                        <th>No Telp Wali</th>
                                        <td id="siswa_no_telp_wali">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>3 Kasus Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <th>Tanggal</th>
                                    <th>Kasus</th>
                                    <th>Jenis Point</th>
                                </thead>
                                <tbody id="siswa_kasus">
        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function () {
        $('#kelas_id').on('change', () => {
            let id = $("#kelas_id").children("option:selected").val();

            if (id !== "") {
                $('#kelas_id').removeAttr('read-only');

                $("#siswa_nip").select2({
                    ajax: {
                        url: `/select2/kasus/kelas/${id}/siswa`,
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

                $('#siswa_nip').on('change',() =>{
                    let siswa_nip = $('#siswa_nip').val();
                    if(siswa_nip !== ""){
                        $.ajax({
                            url: `/kasus/get_siswa/${siswa_nip}`,
                            type: "post",
                            dataType: 'json',
                            delay: 10,
                            data: {
                                _token: CSRF_TOKEN
                            },
                        }).done( (response) => {
                            $('#siswa_nama').html(response.nama);
                            $('#siswa_kelas').html(response.kelas);
                            $('#siswa_point_penghargaan').html(response.point_penghargaan);
                            $('#siswa_point_pelanggaran').html(response.point_pelanggaran);
                            $('#siswa_nama_wali').html(response.nama_wali);
                            $('#siswa_no_telp_wali').html(response.no_telp_wali);
                            
                            document.querySelector('#siswa_kasus').innerHTML = "";
                            if(response.tiga_kasus_terakhir.length > 0){
                                response.tiga_kasus_terakhir.forEach(element => {
                                    document.querySelector('#siswa_kasus').innerHTML += `
                                                            <tr>
                                                                <td>${element.tanggal}</td>
                                                                <td>${element.kasus}</td>
                                                                <td>${element.jenis_point}</td>
                                                            </tr>`;
                                });
                            }else{
                                document.querySelector('#siswa_kasus').innerHTML = "<tr><td colspan='3' class='text-center'>Data tidak tersedia.</td></tr>";
                            }
                        })
                    }
                });
            }
        });

        $('#kategori_point_id').on('change', () => {
            let id = $("#kategori_point_id").children("option:selected").val();

            if (id !== "") {
                $('#point_id').removeAttr('read-only');

                $("#point_id").select2({
                    ajax: {
                        url: `/select2/kasus/${id}/point`,
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

                $('#point_id').on('change', () => {
                    let id = $('#point_id').val();
                    $.ajax({
                        url: `/kasus/get_point/${id}`,
                        dataType: 'json',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        type: 'POST',
                        delay: 10,
                    }).done( (response) => {
                        $('#point').val(response.point);
                    })
                })

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
