@extends('layouts.app')

@section('template_title')
    Setting Koin
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="nk-block nk-block-lg">
    <div class="card card-body pb-5">
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Setting Penukaran Koin</h3>
                    <div class="nk-block-des text-soft">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <form id="postForm" name="postForm" class="gy-3 form-validate" method="POST">
                    @csrf
        
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="label-referral">Minimal Koin</label>
                                <span class="form-note">Minimal penukaran koin dengan kelipatan {{rupiah($koin)}}</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" value="{{isset($koin) ? $koin : 0}}" id="nominal" name="nominal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" id="savedata" class="btn btn-md btn-block btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
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
        url: "{{ route('saved.koin') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postForm').trigger("reset");
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            $('#savedata').html('Simpan');
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            $('#savedata').html('Simpan');
        }
    });
});
</script>
@endsection