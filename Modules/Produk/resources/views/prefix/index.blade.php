@extends('layouts.app')

@section('template_title')
    Prefix
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
                        <h3 class="nk-block-title page-title">Prefix Nomor</h3>
                        <div class="nk-block-des text-soft">
                            <p>Data prefix nomor provider Indonesia</p>
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
                                            <label for="prefix" class="control-label">Prefix Nomor</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="prefix" name="prefix"  required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Operator</label>
                                            <div class="form-control-wrap">
                                                <select name="operator" id="operator" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                                                    @foreach ($operator as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
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
                            <table id="tbl_prefix" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Operator</th>
                                        <th>Prefix</th>
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
var table = $('#tbl_prefix').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ordering: false,
    ajax: "{{ route('prefix.list') }}",
    columns: [
        {
            data: 'operator',
            name: 'operator'
        },
        {
            data: 'prefix',
            name: 'prefix'
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
    $('#modelHeading').html("Tambah Data Prefix");
    $('#modalCreate').modal('show');
});

$('#tbl_prefix').on('click', '.editPost', function () {
    var id = $(this).data('id');
    $.get("{{ route('prefix.index') }}" +'/' + id +'/edit', function (data) {

        $('#modalCreate').modal('show');
        $('#modelHeading').html("Edit Data Prefix");
        $('#prefix').val(data.prefix);
        $('#id').val(data.id);
    })
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postForm').serialize(),
        url: "{{ route('prefix.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postForm').trigger("reset");
            $('#modalCreate').modal('hide');
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            table.draw();
            $('#savedata').html('Save Post');
        },
        error: function (data) {
            $('#savedata').html('Save Post');
        }
    });
});

$('#tbl_prefix').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('prefix.delete') }}",
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
