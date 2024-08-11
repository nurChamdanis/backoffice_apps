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
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Push Command</h3>
                        <div class="nk-block-des text-soft">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="col-lg-8">
                    <div class="card card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="col-lg-12 mt-3">
                                    <div class="nk-block-between">
                                        <div>
                                            <span>Get Token All Vendor</span>
                                        </div>
                                        <div>
                                            <form id="postForm" name="postForm" class="form-horizontal">
                                                @csrf
                                                <button type="submit" id="savedata" class="btn btn-sm btn-success">
                                                    <span>GET TOKEN</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <div class="nk-block-between">
                                        <div>
                                            <span>Clear Chace</span>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-sm btn-success">
                                                <span class="text-white">CLEAR</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

$('#savedata').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postForm').serialize(),
        url: "{{ route('push-command.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postForm').trigger("reset");
            $('#modalCreate').modal('hide');
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            $('#savedata').html('GET TOKEN');
        
        },
        error: function (data) {
            $('#savedata').html('GET TOKEN');
        }
    });
});
</script>
@endsection
