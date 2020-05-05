@extends('layouts.main')


@push('title')
	Detail Siswa
@endpush
@push('header-title')
	Detail Siswa
@endpush


@section('content')
<div class="col-md-12">
  <x-alerts :data="$errors" />
  <div class="card card-danger">
    <div class="card-header">
        <a href="{{ route('user.index') }}" class="btn btn-danger">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-hover">
            <tr>
                <th>Nama</th><td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{ $user->email }}</td>
            </tr>
        </table>
    </div>
  </div>
</div>

<div class="col-md-12">
  <div class="card card-default">
    <div class="card-header">
        <h3><strong>Roles</strong></h3>
        <a href="{{ route('user.add-role',['user' => $user]) }}" class="btn btn-success mt-2 mr-1 mb-1 ml-0">
            <i class="fa fa-plus"></i>
            Tambah
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsice">
            <table class="table table-borderless table-hover">
                <thead>
                    <th>Nama Role</th>
                    <th>Ditambahkan Pada</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                    <tr>
                        <td>
                            {{ $item->nama }}
                        </td>
                        <td>
                            {{ CStr::date($item->created_at) }}
                        </td>
                        <td>
                            <form action="{{ route('user.remove-role',[
                                'user' => $user,
                                'userRole' => $item
                            ]) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger buttonAlerts">
                                    <i class="fa fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@stop

@push('_js')
<script>

</script>
@endpush