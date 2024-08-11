@extends('layouts.app')

@section('template_title')
Api Key Settings
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
                        <h3 class="nk-block-title page-title">API Key</h3>
                        <div class="nk-block-des text-soft">
                            <p>Settings API Key Provider</p>
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
                                    <form id="postForm" name="postForm" class="form-horizontal">                        
                                        @csrf
                
                                        <div class="form-group">
                                            <label for="name" class="control-label">Nama Provider</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Provider" required>
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="api_key" class="control-label">API Key</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Masukan API Key Provider" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="secret" class="control-label">Secret Key</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="secret" name="secret" placeholder="Masukan Secret Key Provider" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="api_url" class="control-label">API URL</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="api_url" name="api_url" placeholder="Masukan API URL Provider" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="callback" class="control-label">Callback URL</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="callback" name="callback" placeholder="Masukan Callback URL" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ip_address" class="control-label">IP Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Masukan IP Address" required>
                                            </div>
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

                    <div class="modal fade" id="modalEdit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeadingEdit"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" name="editForm" class="form-horizontal">                        
                                        @csrf
                
                                        <div class="form-group">
                                            <label for="name" class="control-label">Nama Provider</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="nameE" name="name" placeholder="Masukan Nama Provider">
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="api_key" class="control-label">API Key</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="api_keyE" name="api_key" placeholder="Masukan API Key Provider">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="secret" class="control-label">Secret Key</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="secretE" name="secret" placeholder="Masukan Secret Key Provider">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="username" class="control-label">Username</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="usernameE" name="username" placeholder="Masukan Username">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="api_url" class="control-label">API URL</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="api_urlE" name="api_url" placeholder="Masukan API URL Provider">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="callback" class="control-label">Callback URL</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="callbackE" name="callback" placeholder="Masukan Callback URL">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ip_address" class="control-label">IP Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="ip_addressE" name="ip_address" placeholder="Masukan IP Address">
                                            </div>
                                        </div>
                
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="editData" value="create">Save Edited
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
                                        <th>Provider</th>
                                        <th>API Key</th>
                                        <th>Secret Key</th>
                                        <th>API URL</th>
                                        <th>Callback URL</th>
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
    responsive: true,
    ordering: false,
    ajax: "{{ route('api_key.list') }}",
    columns: [
        {
            data: 'provider',
            name: 'provider'
        },
        {
            data: 'api_key',
            name: 'api_key'
        },
        {
            data: 'secret',
            name: 'secret'
        },
        {
            data: 'api_url',
            name: 'api_url'
        },
        {
            data: 'callback_url',
            name: 'callback_url'
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
    $('#modelHeading').html("Tambah Data");
    $('#modalCreate').modal('show');
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postForm').serialize(),
        url: "{{ route('api_key.store') }}",
        type: "POST",
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
            url: "{{ route('api_key.delete') }}",
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

$('body').on('click', '.editPost', function () {
    var id = $(this).data('id');
    $.get("{{ route('api_key.index') }}" +'/' + id +'/edit', function (data) {
        $('#modelHeadingEdit').html("Edit Data");
        $('#editData').val("edit-user");
        $('#nameE').val(data.provider);
        $('#api_keyE').val(data.key);
        $('#secretE').val(data.secret);
        $('#api_urlE').val(data.api_url);
        $('#callbackE').val(data.callback_url);
        $('#ip_addressE').val(data.ip_address);
        $('#usernameE').val(data.username);
        $('#modalEdit').modal('show');
        $('#id').val(data.id);
    })
});

</script>
@endsection
