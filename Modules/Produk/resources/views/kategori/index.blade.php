@extends('layouts.app')

@section('template_title')
    Kategori / Brand
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
                        <h3 class="nk-block-title page-title">Kategori / Brand</h3>
                        <div class="nk-block-des text-soft">
                            <p>Settings Kategori Fitur PPOB</p>
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
                                            <label for="name" class="control-label">Nama Kategori</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="code" class="control-label">Kode Kategori</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="code" name="code"  required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Type Menu</label>
                                            <div class="form-control-wrap">
                                                <select name="type" id="type" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                                                    @foreach ($type as $item)
                                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="icon" class="control-label">Icon Menu</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" id="icon" name="icon"  required>
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

                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">

                        <div class="card-inner">
                            <table id="tbl_kategori" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kategori/Brand</th>
                                        <th>Type</th>
                                        <th>Icon</th>
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
var table = $('#tbl_kategori').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('kategori.list') }}",
    columns: [
        {
            data: 'code',
            name: 'code'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'type',
            name: 'type'
        },
        {
            data: 'icon',
            name: 'icon'
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
    $('#modelHeading').html("Tambah Data Kategori/Brand");
    $('#modalCreate').modal('show');
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    var files = $('#icon')[0].files;
    var fd = new FormData();

    fd.append('name', $('#name').val());
    fd.append('code', $('#code').val());
    fd.append('type', $('#type').val());
    fd.append('icon',files[0]);
    fd.append('_token',CSRF_TOKEN);

    $.ajax({
        data: fd,
        url: "{{ route('kategori.store') }}",
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

$('#tbl_kategori').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('kategori.delete') }}",
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
