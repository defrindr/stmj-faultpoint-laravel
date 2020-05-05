@extends('layouts.main')

@push('title', 'Detail User')
@push('header-title', 'Detail User')

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
                    <th>Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-default">
        <div class="card-header">
            <h3><strong>Roles</strong></h3>
            <a href="{{ route('user.add-role', $user) }}" class="btn btn-success mt-2 mr-1 mb-1 ml-0">
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
                                <form action="{{ route('user.remove-role', [$user, $item]) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger deleteAlerts">
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
    $('.deleteAlerts').on('click', function (e) {
        e.preventDefault();
        let form = $(this).parents('form');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data akan dihapus secara permanen dari database setelah proses ini dijalankan.",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) $(form).submit();
        })
    });

</script>
@endpush
