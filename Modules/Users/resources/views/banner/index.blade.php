@extends('layouts.app')

@section('template_title')
    Banner
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
                        <h3 class="nk-block-title page-title">Slide Banner</h3>
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
                                    <form id="postForm" name="postForm" class="form-horizontal" enctype="multipart/form-data">                        
                                        @csrf
                
                                        <div class="form-group">
                                            <label for="title" class="control-label">Title</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="subtitle" class="control-label">Subtitle</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="subtitle" name="subtitle"  required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="link" class="control-label">Link</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="link" name="link"  required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Type Menu</label>
                                            <div class="form-control-wrap">
                                                <select name="type" id="type" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                                                    <option value="BannerHome">Banner Home</option>
                                                    <option value="Intro">Intro</option>
                                                    <option value="BannerProduk">Banner Produk</option>
                                                    <option value="BannerPromo">Banner Promo</option>
                                                    <option value="BannerAds">Banner Ads</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="image" class="control-label">File Banner</label>
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" id="image" name="image"  required>
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
                            <table id="tbl_banner" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Type</th>
                                        <th>Link</th>
                                        <th>Image</th>
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
var table = $('#tbl_banner').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('banner.list') }}",
    columns: [
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'subtitle',
            name: 'subtitle'
        },
        {
            data: 'type',
            name: 'type'
        },
        {
            data: 'link',
            name: 'link'
        },
        {
            data: 'image',
            name: 'image'
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
    $('#modelHeading').html("Tambah Data Banner");
    $('#modalCreate').modal('show');
});

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    var files = $('#image')[0].files;
    var fd = new FormData();

    fd.append('title', $('#title').val());
    fd.append('subtitle', $('#subtitle').val());
    fd.append('link', $('#link').val());
    fd.append('type', $('#type').val());
    fd.append('image',files[0]);
    fd.append('_token',CSRF_TOKEN);

    $.ajax({
        data: fd,
        url: "{{ route('banner.store') }}",
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

$('#tbl_banner').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('banner.delete') }}",
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
