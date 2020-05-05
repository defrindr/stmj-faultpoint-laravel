@extends('layouts.mains')
@section('title','Update Hari Efektif')
@section('container')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Update Efektif</h1>
    <form method="post" action="/hari-tidak-efektif/{{ $hariTidakEfektif->id }}">
    @method('patch')
    @csrf    

  <div class="form-group">
    <label for="tanggal" class="mt-3">Tanggal Tidak Efektif</label>
    <input type="text" class="date form-control @error('tanggal') is-invalid @enderror" id="tanggal" 
    placeholder="Masukkan Tanggal" name="tanggal" value="{{ $hariTidakEfektif->tanggal }}">
    @error('tanggal')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  
  <div class="form-group">
    <label for="keterangan" class="mt-3">Keterangan</label>
    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" 
    placeholder="Masukkan keterangan" name="keterangan" value="{{ $hariTidakEfektif->keterangan }}">
    @error('keterangan')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <button type="submit" class="bnt btn-primary">Update Data!</button>
</form>
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'yyyy-mm-dd'

     });  

</script>

</div>
</div>
</div>
@endsection

    