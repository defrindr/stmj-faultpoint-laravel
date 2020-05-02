@extends('layouts.mains')
@section('title','Detail Point')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Detail Point: {{$point->peraturan }}</h1>
    <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Kategori: {{$point->kategori_point->nama }}</h5>
    <p class="card-text">Interval Waktu : {{$point->interval_waktu }}</p>
    <p class="card-text">Point : {{$point->point }}</p>
    <p class="card-text">Sanksi : {{$point->sanksi }}</p>
   
    <a href="{{url('point/')}}" class="card-link">Kembali</a>

   
 </div>
</div>


</div>
</div>
</div>
@endsection

    