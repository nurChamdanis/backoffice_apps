@extends('layouts.app')

@section('template_title')
    Adjust Saldo
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
                        <h3 class="nk-block-title page-title">Adjust Saldo</h3>
                        <div class="nk-block-des text-soft">
                            <p>Ubah Saldo User</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                        data-bs-toggle="dropdown"><em class="icon ni ni-minus"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="../members" id="createNewPost">
                                                    <span>Cancel</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">

                        <div class="card-inner">
                            <form action="{{ url('backoffice/v2/updateSaldo',$mber->id) }}" method='post'>
                                {{ csrf_field() }}
                                <div class="my-3 p-3 bg-body rounded shadow-sm">

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="type">Tipe Perubahan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="plus">Penambahan</option>
                                                <option value="minus">Pengurangan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="saldo" class="col-sm-2 col-form-label">Jenis Perubahan</label>
                                        <div class="col-sm-10 flex-row">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="jenis" value="saldo" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1">
                                                    Saldo
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="jenis" value="poin" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio2">
                                                    Poin
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio3" name="jenis" value="koin" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio3">
                                                    Koin
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="saldo" id="label_saldo" class="col-sm-2 col-form-label">Jumlah Saldo</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name='saldo' value="{{ $mber->saldo }}" id="saldo">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="submitsaldo" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10"><button type="submit" class="btn btn-primary" >SIMPAN</button></div>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="mb-3 row">
                                        <label for="saldo" id="label_saldo" class="col-sm-2 col-form-label">Jumlah Saldo Awal</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" readonly value="{{ $mber->saldo }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="saldo" id="label_saldo" class="col-sm-2 col-form-label">Jumlah Koin Awal</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" readonly value="{{ $mber->koin }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="saldo" id="label_saldo" class="col-sm-2 col-form-label">Jumlah Poin Awal</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" readonly value="{{ $mber->poin }}">
                                        </div>
                                    </div>
                                </div>
                            </form>

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
<script>
    var saldo = "{{ $mber->saldo }}"
    var poin = "{{ $mber->poin }}"
    var koin = "{{ $mber->koin }}"

    $("input[type=radio]").on("change", function() {
        //check if radio is checked and value of checked one is `others`
        if($(this).val() == "saldo") {
            
            $("#saldo").val(saldo);
            $("#label_saldo").html("Jumlah Saldo");

        }else if ($(this).val() == "poin"){

            $("#saldo").val(poin);
            $("#label_saldo").html("Jumlah Poin");

        }else if(($(this).val() == "koin")){

            $("#saldo").val(koin);
            $("#label_saldo").html("Jumlah Koin");

        }
    })
</script>
@endsection