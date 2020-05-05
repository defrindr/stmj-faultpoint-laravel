@extends('layouts.main')

@push('title', 'Daftar Hari Efektif')
@push('header-title', 'Menu Hari Efektif')

@push('_css')
<style>
    .onoffswitch {
        position: relative;
        width: 60px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .onoffswitch-checkbox {
        display: none;
    }

    .onoffswitch-label {
        display: block;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid #fff;
        border-radius: 15px;
    }

    .onoffswitch-inner {
        display: block;
        width: 200%;
        margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }

    .onoffswitch-inner:before,
    .onoffswitch-inner:after {
        display: block;
        float: left;
        width: 50%;
        height: 20px;
        padding: 0;
        line-height: 20px;
        font-size: 10px;
        color: white;
        font-family: Trebuchet, Arial, sans-serif;
        font-weight: bold;
        box-sizing: border-box;
    }

    .onoffswitch-inner:before {
        content: "ON";
        padding-left: 11px;
        background-color: #34A7C1;
        color: #FFFFFF;
    }

    .onoffswitch-inner:after {
        content: "OFF";
        padding-right: 11px;
        background-color: #DEDEDE;
        color: #999999;
        text-align: right;
    }

    .onoffswitch-switch {
        display: block;
        width: 12px;
        margin: 6px;
        background: #FFFFFF;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 36px;
        border: 2px solid #fff;
        border-radius: 20px;
        transition: all 0.3s ease-in 0s;
    }

    .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }

    .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-switch {
        right: 0px;
    }

</style>
@endpush

@section('content')
<div class="col-md-12">
    <x-alerts :data="$errors" />
    <div class="card card-success">
        <div class="card-body">
            <table class="table table-striped table-borderless w-100" id="hari-efektif-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Hari</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@push('_js')
<script>
    $(function () {
        $('#hari-efektif-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route("datatables.hari-efektif") ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'hari',
                    name: 'hari'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

    let update = (param) => {
        let url = '/hari-efektif/update/' + param.id;
        let data = {
            _token: param.token
        }

        $.ajax({
            url: url,
            method: 'put',
            dataType: 'json',
            data: data,
            success: (res) => {
                let icon = "";
                let title = "";
                let text = "";
                if (res.success) {
                    icon = "success";
                    title = "Berhasil ...";
                } else {
                    icon = "error";
                    title = "Oops ...";
                }

                text = res.message;

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                });
            }
        });
    }

</script>
@endpush
