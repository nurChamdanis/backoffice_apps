@extends('layouts.app')

@section('template_title')
    Pascabayar
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
                        <h3 class="nk-block-title page-title">Produk Pascabayar</h3>
                        <div class="nk-block-des text-soft">
                            <p>Data semua produk Pascabayar</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <div class="" data-content="pageMenu">
                                <a href="javascript:void(0)" id="createNewPost" class="btn btn-warning btn-outline-white">
                                    <span>Markup Shared Fee</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-sm-center">
                    <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="postForm" name="postForm" class="form-horizontal">                        
                                        @csrf
                
                                        <div class="form-group">
                                            <label for="value" class="control-label">Markup Per Produk</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" id="value" name="value" placeholder="Masukan Mark Up" required>
                                                <input type="hidden" name="postpaid" value="0">
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

                <div class="modal fade" id="editMarkup" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="markupHeading"></h4>
                            </div>
                            <div class="modal-body">
                                <form id="postFormmarkup" name="postFormmarkup" class="form-horizontal">                        
                                    @csrf
            
                                    <div class="form-group">
                                        <label for="value" class="control-label" id="labelValue"></label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="value" name="value" required>
                                            <input type="text" hidden class="form-control" id="produk_id" name="produk_id">
                                        </div>
                                    </div>
                    
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="save" value="create">Save Post
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">

                        <div class="card-inner">
                            <table id="tbl_pra" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Tipe</th>
                                        <th>Admin Fee</th>
                                        <th>Markup</th>
                                        <th>Shared Fee</th>
                                        <th>Status</th>
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
var table = $('#tbl_pra').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ordering: false,
    ajax: "{{ route('pascabayar.list') }}",
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
            data: 'desc',
            name: 'desc'
        },
        {
            data: 'type',
            name: 'type'
        },
        {
            data: 'price',
            name: 'price'
        },
        {
            data: 'margin',
            name: 'margin'
        },
        {
            data: 'sale_price',
            name: 'sale_price'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
        },
    ]
});

$('#tbl_pra').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('pascabayar.delete') }}",
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

$('#tbl_pra').on('click', '.showEditMarkup', function () {
    var id = $(this).data('id');
    $.get("{{ route('prabayar.index') }}" +'/' + id +'/edit', function (data) {
        $('#save').val("create-post");
        $('#value').val(data.margin);
        $('#produk_id').val(data.id);
        $('#labelValue').html('Markup Produk '+ data.name + ' ' + data.description);
        $('#markupHeading').html("Setting Mark Up " + data.name + ' ' + data.description);
        $('#editMarkup').modal('show');
    });
})

$('#save').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $('#spinner-div').show();
    $.ajax({
        data: $('#postFormmarkup').serialize(),
        url: "{{ route('pascabayar.update') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#spinner-div').hide();
            $('#postFormmarkup').trigger("reset");
            $('#editMarkup').modal('hide');
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            table.draw();
        
        },
        error: function (data) {
            $('#spinner-div').hide();
            $('#save').html('Save Changes');
        }
    });
});

$('#createNewPost').click(function () {
    $('#savedata').val("create-post");
    $('#id').val('');
    $('#postForm').trigger("reset");
    $('#modelHeading').html("Setting Mark Up");
    $('#ajaxModelexa').modal('show');
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $('#spinner-div').show();
    $.ajax({
        data: $('#postForm').serialize(),
        url: "{{ route('pascabayar.bulk') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#spinner-div').hide();
            $('#postForm').trigger("reset");
            $('#ajaxModelexa').modal('hide');
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            table.draw();
        
        },
        error: function (data) {
            $('#spinner-div').hide();
            $('#savedata').html('Save Changes');
        }
    });
});

</script>
@endsection
