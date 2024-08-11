@extends('layouts.app')

@section('template_title')
    Operator
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Data Operator</h3>
                        <div class="nk-block-des text-soft">
                            <p></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                        data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="javascript:void(0)" id="createNewPost">
                                                    <span>Add New</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="modal fade" id="modalCreate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admins.store') }}" class="form-validate is-alter"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="name" class="control-label">Nama Lengkap</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="control-label">Nomor Tlp</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="control-label">Alamat Email</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Hak Akses</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" data-search="on" id="activated" name="activated" required>
                                                    @foreach ($role as $key => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="savedata"
                                                value="create">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">

                        <div class="card-inner">
                            <table id="tbl_opr" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nama Operator</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Hak Akses</th>
                                        <th>Tgl Join</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>  
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var table = $('#tbl_opr').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('admins.list') }}",
    columns: [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'activated',
            name: 'activated'
        },
        {
            data: 'join',
            name: 'join'
        },
        {
            data: 'last_login',
            name: 'last_login'
        },
        {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
        },
    ]
});

$('#createNewPost').click(function () {
    $('#savedata').val("create-post");
    $('#id').val('');
    $('#postForm').trigger("reset");
    $('#modelHeading').html("Tambah Data Operator");
    $('#modalCreate').modal('show');
});


$('#tbl_opr').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('admins.delete') }}",
            type: 'POST',
            data: {_token: CSRF_TOKEN, id: id},
            success: function(response){
                if(response.success == 1){
                    table.ajax.reload();
                }else{
                    alert("Invalid ID.");
                }
            }
        });
    }
});

$('#tbl_opr').on('click','.reset-password',function(){
    var userId = $(this).data('id');
    var resetConfirm = confirm("Are you sure Reset Password default to 'Bilpay2024@'?");
    if (resetConfirm == true) {
        $.ajax({
            url: "{{ route("reset.password") }}",
            type: 'POST',
            data: {_token: CSRF_TOKEN, id: userId},
            success: function(response){
                if(response.success == 1){
                    table.ajax.reload();
                }else{
                    alert("Invalid ID.");
                }
            }
        });
    }
});
</script>

@endsection
