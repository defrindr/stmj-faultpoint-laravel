@extends('layouts.mains')
@section('title','Absensi')
@section('container')

<div class="container">
<div class="row">
<div class="col-10">
    <h1 class="mt-3">Kategori Point</h1>
    <a href="/kategori-point/create" class="btn btn-primary my-3">Tambah Kategori Point</a>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <table class="table">
<thead class="thead-dark">
  <tr>
  <th scope="col">#</th>
  <th scope="col">Nama</th>
  <th scope="col">Jenis Point</th>
  <th scope="col">aksi</th>
  </tr>
    </thead>
    <tbody>
    @foreach($KategoriPoint as $efk)
    <tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td>{{$efk->nama}}</td>
    <td>{{$efk->jenis_point}}</td>
    <td>
    <!-- <a href="{{ url('/kategori-point/'.$efk->id) }}" class="badge badge-success">Detail</a> -->
    <a href="kategori-point/{{ $efk->id }}/edit" class="btn btn-primary">Edit</a>
    <form action="kategori-point/{{ $efk->id }}" method="post" class="d-inline">
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

    