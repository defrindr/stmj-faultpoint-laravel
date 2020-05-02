@extends('layouts.mains')
@section('title','Absensi')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Hari Tidak Efektif</h1>
    <a href="/hari-tidak-efektif/create" class="btn btn-primary my-3">Tambah Hari Tidak efektif</a>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <table class="table">
<thead class="thead-dark">
  <tr>
  <th scope="col">#</th>
  <th scope="col">Tanggal</th>
  <th scope="col">Status</th>
  <th scope="col">Keterangan</th>
  <th scope="col">Tanggal Dibuat</th>
  <th scope="col">aksi</th>
  </tr>
    </thead>
    <tbody>
    @foreach($HariTidakEfektif as $efk)
    <tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td>{{$efk->tanggal}}</td>
    <td>{{$efk->status}}</td>
    <td>{{$efk->keterangan}}</td>
    <td>{{$efk->created_at}}</td>
    <td>
    <a href="{{ url('/hari-tidak-efektif/'.$efk->id) }}" class="badge badge-success">Detail</a>
    
    </td>
    </tr>
    @endforeach
    </tbody>
</table>


</div>
</div>
</div>
@endsection

    