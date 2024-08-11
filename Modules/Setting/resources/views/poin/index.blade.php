@extends('layouts.app')

@section('template_title')
    Setting Poin
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
                    <h3 class="nk-block-title page-title">Setting Poin</h3>
                    <div class="nk-block-des text-soft">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-3 align-center">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="label-text">Poin Deposit</label>
                        <span class="form-note">Modul bonus poin deposit</span>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="poin_depo" id="poin-deposit">
                            <label class="custom-control-label" for="poin-deposit" id="label-poin-deposit">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="inputNominal" hidden>
                <form id="postFormDep" name="postFormDep" class="gy-3 form-validate" method="POST">
                    @csrf
        
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Minimal Deposit</label>
                                <span class="form-note">Minimal deposit untuk mendapatkan poin</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" value="{{isset($nomDeposit) ? $nomDeposit->minimal : 0}}" id="minimal" name="minimal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Nominal Poin</label>
                                <span class="form-note">Bonus poin untuk deposit</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" value="{{isset($nomDeposit) ? $nomDeposit->nominal : 0}}" id="nominal" name="nominal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" id="savedatadep" class="btn btn-md btn-block btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row g-3 align-center mt-3">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label" for="label-referral">Poin Referral</label>
                        <span class="form-note">Modul bonus poin referral</span>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="poin_ref" id="poin-referral">
                            <label class="custom-control-label" for="poin-referral" id="label-poin-referral">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="inputNominalRef" hidden>
                <form id="postFormRef" name="postFormRef" class="gy-3 form-validate" method="POST">
                    @csrf
        
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Nominal Poin Shared</label>
                                <span class="form-note">Bonus poin untuk share kode referral</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" value="{{isset($nomReferral) ? $nomReferral->nominal : 0}}" id="nominal" name="nominal"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Minimal Shared</label>
                                <span class="form-note">Jumlah minimal share kode referral</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" min="1" value="{{isset($nomReferral->minimal) ? $nomReferral->minimal : 1}}" id="minimalShare" name="minimalShare"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Nominal Poin New Users</label>
                                <span class="form-note">Bonus poin untuk user baru dengan referral</span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" value="{{isset($nomReferral) ? $nomReferral->nominal_share : 0}}" id="nominal_share" name="nominal_share"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" id="savedataref" class="btn btn-md btn-block btn-primary">Simpan</button>
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
$('#poin-deposit').on('change', function() {
    var valDep = $(this).is(':checked');
    $.ajax({
        data: {
            poin_depo: valDep == true ? 'on' : 'off',
            _token: CSRF_TOKEN
        },
        url: "{{ route('set.poin.dep') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            NioApp.Toast(data[0].message, 'error', {
                position: 'top-center'
            });
        }
    });
});

$('#savedatadep').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postFormDep').serialize(),
        url: "{{ route('set.nom.dep') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postFormDep').trigger("reset");
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            $('#savedatadep').html('Update');
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            $('#savedatadep').html('Update');
        }
    });
});

$('#poin-referral').on('change', function() {
    var valRef = $(this).is(':checked');
    $.ajax({
        data: {
            poin_ref: valRef == true ? 'on' : 'off',
            _token: CSRF_TOKEN
        },
        url: "{{ route('set.poin.ref') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            NioApp.Toast(data[0].message, 'error', {
                position: 'top-center'
            });
        }
    });
});

$('#savedataref').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');
    $.ajax({
        data: $('#postFormRef').serialize(),
        url: "{{ route('set.nom.ref') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
    
            $('#postFormRef').trigger("reset");
            NioApp.Toast(data[0].message, 'success', {
                position: 'top-center'
            });
            $('#savedataref').html('Update');
            setTimeout(() => {
                location.reload();
            }, 1000);
        
        },
        error: function (data) {
            $('#savedataref').html('Update');
        }
    });
});

var statusDep = "{{$valdev}}"
if(statusDep  === 'on'){
    $('#poin-deposit').attr('checked', true)
    $('#label-poin-deposit').html('Active')
    $('#inputNominal').attr('hidden', false)
}else if(statusDep === false) {
    $('#poin-deposit').attr('checked', false)
    $('#label-poin-deposit').html('Inactive')
    $('#inputNominal').attr('hidden', true)
}

var statusRef = "{{$valref}}"
if(statusRef  === 'on'){
    $('#poin-referral').attr('checked', true)
    $('#label-poin-referral').html('Active')
    $('#inputNominalRef').attr('hidden', false)
}else if(statusRef === false) {
    $('#poin-referral').attr('checked', false)
    $('#label-poin-referral').html('Inactive')
    $('#inputNominalRef').attr('hidden', true)
}
</script>
@endsection