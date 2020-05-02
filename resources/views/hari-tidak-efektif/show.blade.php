@extends('layouts.mains')
@section('title','Detail Hari Tidak Efektif')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Detail pada Tanggal {{$hariTidakEfektif->tanggal }}</h1>
    <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Tanggal Tidak Efektif {{$hariTidakEfektif->tanggal }}</h5>
    <p class="card-text">Keterangan : {{$hariTidakEfektif->keterangan }}</p>
    

    <a href="{{ $hariTidakEfektif->id }}/edit" class="btn btn-primary">Edit</a>
    <form action="{{ $hariTidakEfektif->id }}" method="post">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-danger">Delete</button>
    </form>
 </div>
</div>


</div>
</div>
</div>
@endsection

    