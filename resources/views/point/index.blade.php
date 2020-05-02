@extends('layouts.mains')
@section('title','Absensi')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Point</h1>
    <a href="/point/create" class="btn btn-primary my-3">Tambah  Point</a>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <table class="table">
<thead class="thead-dark">
  <tr>
  <th scope="col">#</th>
  <th scope="col">Peraturan</th>
  <th scope="col">Interval waktu</th>
  <th scope="col">Sanksi</th>
  <th scope="col">Kategori</th>
  <th scope="col">Created At</th>
  <th scope="col">aksi</th>
  </tr>
    </thead>
    <tbody>
    @foreach($Point as $efk)
    <tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td>{{$efk->peraturan}}</td>
    <td>{{$efk->interval_waktu}}</td>
    <td>{{$efk->sanksi}}</td>
    <td>{{$efk->kategori_point->nama}}</td>
    <td>{{$efk->created_at}}</td>
    <td>
    <!-- <a href="{{ url('/kategori-point/'.$efk->id) }}" class="badge badge-success">Detail</a> -->
    <a href="point/{{ $efk->id }}" class="btn btn-primary">Detail</a>
    <a href="point/{{ $efk->id }}/edit" class="btn btn-primary">Edit</a>
    <form action="point/{{ $efk->id }}" method="post" class="d-inline">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    </td>
    </tr>
    @endforeach
    </tbody>
</table>


</div>
</div>
</div>
@endsection

    