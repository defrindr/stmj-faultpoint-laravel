@extends('layouts.mains')
@section('title','Form Point')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Form Point</h1>
<form method="post" action="/point">
    @csrf    

  <div class="form-group">
    <label for="peraturan" class="mt-3">Peraturan</label>
    <input type="text" class="form-control @error('peraturan') is-invalid @enderror" id="peraturan" 
    placeholder="Masukkan peraturan" name="peraturan" value="{{ old('peraturan') }}">
    @error('peraturan')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="interval_waktu" class="mt-3">Interval Waktu</label>
    <input type="text" class="form-control @error('interval_waktu') is-invalid @enderror" id="interval_waktu" 
    placeholder="Masukkan interval_waktu" name="interval_waktu" value="{{ old('interval_waktu') }}">
    @error('interval_waktu')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="point" class="mt-3">Point</label>
    <input type="text" class="form-control @error('point') is-invalid @enderror" id="point" 
    placeholder="Masukkan point" name="point" value="{{ old('point') }}">
    @error('point')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="sanksi" class="mt-3">Sanksi</label>
    <input type="text" class="form-control @error('sanksi') is-invalid @enderror" id="sanksi" 
    placeholder="Masukkan sanksi" name="sanksi" value="{{ old('sanksi') }}">
    @error('sanksi')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="kategori_point_id" class="mt-3">Kategori Point</label>
    <select name="kategori_point_id" class="form-control @error('kategori_point_id') is-invalid @enderror" id="kategori_point_id"
    name="kategori_point_id" value="{{ old('kategori_point_id') }}">

    @foreach ($KategoriPoint as $rows)
    <option value="{{ $rows->id }}"> {{ $rows->nama }}</option>
    @endforeach

    </select>
    @error('kategori_point_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
  
  <button type="submit" class="bnt btn-primary">Tambah Data!</button>
</form>


</div>
</div>
</div>
@endsection

    