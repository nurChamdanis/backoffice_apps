@extends('layouts.app')

@section('template_title')
    Settings
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="nk-block nk-block-lg">
    <div class="card card-body py-5">
        <div class="col-md-6">
            <form id="postForm" name="postForm" class="gy-3 form-validate" method="POST">
                @csrf
    
                <div class="row g-3 align-center">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label">Title Maintenance Mode</label>
                            <span class="form-note">Pesan singkat untuk mode maintnance</span>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="title" name="title"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-center">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label" for="label-text">Maintenance Mode</label>
                            <span class="form-note">Enable to make website make offline.</span>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="mode" id="site-off">
                                <label class="custom-control-label" for="site-off" id="label-mode">Offline</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-7 offset-lg-5">
                        <div class="form-group mt-2">
                            <button type="submit" id="savedata" class="btn btn-md btn-block btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
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
$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postForm').serialize(),
        url: "{{ route('maintenance.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postForm').trigger("reset");
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            $('#savedata').html('Update');
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            $('#savedata').html('Update');
        }
    });
});

</script>
@php
    $m = $val;
    $md = $m->mode;
    $tl = $m->title;
@endphp
<script>
    var status = "{{$md}}"
    var tl = "{{$tl}}"
    if(status == 'on'){
        $('#site-off').attr('checked', true)
        $('#label-mode').html('Online')
        $('#title').val(tl)
    }else {
        $('#site-off').attr('checked', false)
        $('#title').val(tl)
        $('#label-mode').html('Offline')
    }
</script>
@endsection