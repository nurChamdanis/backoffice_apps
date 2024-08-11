@extends('layouts.app')

@section('template_title')
    Menu PPOB
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
                        <h3 class="nk-block-title page-title">Manajer Menu</h3>
                        <div class="nk-block-des text-soft">
                            <p>Settings Menu Aplikasi Fitur PPOB</p>
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
                                    <form id="postForm" name="postForm" class="form-horizontal" enctype="multipart/form-data">                        
                                        @csrf
                
                                        <div class="form-group">
                                            <label for="name" class="control-label">Nama Menu</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="screen_name" class="control-label">Screen Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="screen_name" name="screen_name"  required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Type Menu</label>
                                            <div class="form-control-wrap">
                                                <select name="type" id="type" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                                                    <option value="Prabayar">Prabayar</option>
                                                    <option value="Pascabayar">Pascabayar</option>
                                                    <option value="Donasi">Donasi</option>
                                                    <option value="Travel">Travel</option>
                                                    <option value="Kesehatan">Kesehatan</option>
                                                    <option value="Promo">Promo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <div class="form-control-wrap">
                                                <select name="status" id="status" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                                                    <option value="1">ACTIVE</option>
                                                    <option value="0">INACTIVE</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="position" class="control-label">Position Menu</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" id="position" name="position"  required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="icon" class="control-label">Icon Menu</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" id="icon" name="icon"  required>
                                            </div>
                                        </div>

                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" name="ready" id="customSwitch2">
                                            <label class="custom-control-label" for="customSwitch2">Show Menu</label>
                                        </div>
                
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Post
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
                            <table id="tbl_key" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Menu Name</th>
                                        <th>Screen Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Ready</th>
                                        <th>Position</th>
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
var table = $('#tbl_key').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('menu.list') }}",
    columns: [
        {
            data: 'icon',
            name: 'icon'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'screen_name',
            name: 'screen_name'
        },
        {
            data: 'type',
            name: 'type'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'ready',
            name: 'ready'
        },
        {
            data: 'position',
            name: 'position'
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
    $('#modelHeading').html("Tambah Data Menu Apps");
    $('#modalCreate').modal('show');
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    var files = $('#icon')[0].files;
    var fd = new FormData();

    fd.append('name', $('#name').val());
    fd.append('screen_name', $('#screen_name').val());
    fd.append('type', $('#type').val());
    fd.append('status', $('#status').val());
    fd.append('ready', $('#customSwitch2').val());
    fd.append('position', $('#position').val());
    fd.append('icon',files[0]);
    fd.append('_token',CSRF_TOKEN);

    $.ajax({
        data: fd,
        url: "{{ route('menu.store') }}",
        method: "POST",
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
    
            $('#postForm').trigger("reset");
            $('#modalCreate').modal('hide');
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            table.draw();
        
        },
        error: function (data) {
            $('#savedata').html('Save Changes');
        }
    });
});

$('#tbl_key').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('menu.delete') }}",
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
</script>
@endsection
