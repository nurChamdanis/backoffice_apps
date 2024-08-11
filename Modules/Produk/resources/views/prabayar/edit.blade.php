@extends('layouts.app')

@section('template_title')
    Edit Prabayar
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div>
                <span class="text-danger italic">
                    Apabila auto rename produk aktif, secara otomatis perubahan <b>Nama</b> dan <b>Deskripsi</b> disini akan otomatis direplace
                </span>
            </div>
            <form action="{{route('update.detail.pra', [$produk->id])}}" method="POST" class="form-horizontal" enctype="multipart/form-data">    
                @method('POST')                    
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Kode Produk</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="code" disabled value="{{$produk->code}}">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="name" class="control-label">Nama Produk
                                <span class="text-danger ff-italic">*</span>
                            </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" required value="{{$produk->name}}">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="description" class="control-label">Deskripsi Produk
                                <span class="text-danger ff-italic">*</span>
                            </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="description" name="description" required value="{{$produk->description}}">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="type" class="control-label">Menu Produk</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="type" name="type" disabled value="{{$produk->type}}">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="category" class="control-label">Kategori Produk</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="category" name="category" disabled value="{{$produk->category}}">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="price" class="control-label">Harga Produk</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="price" name="price" disabled value="{{rupiah($produk->price)}}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-5">
        
                        <div class="d-flex justify-content-between">

                            <div class="form-group">
                                <label for="status" class="control-label">Status Produk
                                </label><br>
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" name="status" id="status">
                                    <label class="custom-control-label" id="label_status" for="status">Aktif</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="is_promo" class="control-label">Produk Promo
                                </label><br>
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" name="is_promo" id="is_promo">
                                    <label class="custom-control-label" id="label_is_promo" for="is_promo">Tidak</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="prabayar" class="control-label">Produk Prabayar
                                </label><br>
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" name="prabayar" id="prabayar">
                                    <label class="custom-control-label" id="label_prabayar" for="prabayar">Tidak</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="margin" class="control-label">Markup Produk
                                <span class="text-danger ff-italic">*</span>
                            </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="margin" name="margin" required value="{{rupiah($produk->margin)}}">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="sale_price" class="control-label">Harga Jual
                            </label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="sale_price" name="sale_price" readonly value="{{rupiah($produk->sale_price)}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="discount" id="discount_lbl" class="control-label">Potongan Produk (%)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="discount" name="discount" disabled value="{{$produk->discount}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="poin" class="control-label">Poin Produk</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="poin" name="poin" value="{{$produk->poin}}">
                            </div>
                        </div>
                        
                    </div>
                </div>
    
                <div class="col-sm-offset-2 col-sm-10 mt-3">
                    <button type="submit" id="updateData" class="btn btn-primary btn-sm">
                        Update Data
                    </button>
                    <a href="{{route('prabayar.index')}}"class="btn btn-warning btn-sm">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>  

<script type="text/javascript">
    var status = "{{$produk->status}}"
    var promo = "{{$produk->is_promo}}"
    var prabayar = "{{$produk->prabayar}}"

    if(status == 1){
        $('#status').attr('checked', true)
        $('#label_status').html('Aktif')
    }else {
        $('#status').attr('checked', false)
        $('#label_status').html('Tidak Aktif')
    }

    if(promo == 1){
        $('#is_promo').attr('checked', true)
        $('#label_is_promo').html('Aktif')
        $('#discount').attr('disabled', false)
        $('#discount_lbl').html('Potongan Produk (%) <span class="text-danger">*</span>')
    }else {
        $('#is_promo').attr('checked', false)
        $('#label_is_promo').html('Tidak Aktif')
        $('#discount').attr('disabled', true)
        $('#discount_lbl').html('Potongan Produk (%)')
    }

    if(prabayar == 1){
        $('#prabayar').attr('checked', true)
        $('#label_prabayar').html('YA')
    }else {
        $('#prabayar').attr('checked', false)
        $('#label_prabayar').html('TIDAK')
    }

    $('#is_promo').on('change', function(){
        if ($(this).is(':checked')) {
            $('#label_is_promo').html('Aktif')
            $('#discount').attr('disabled', false)
            $('#discount').attr('required', true)
            $('#discount_lbl').html('Potongan Produk (%) <span class="text-danger">*</span>')

        }else {
            $('#label_is_promo').html('Tidak Aktif')
            $('#discount').attr('disabled', true)
            $('#discount').val(0)
            $('#discount_lbl').html('Potongan Produk (%)')
        }
    })

    $('#margin').on('change', function(){
        var mrg = $('#margin').val()
        var hrg = "{{$produk->price}}"
        var saleP = parseInt(hrg) + parseInt(mrg);
        $('#sale_price').val(saleP)
    })

    $('#discount').on('change', function(){
        var mrg = $('#margin').val()
        var disc = $('#discount').val()
        var nomPot = parseInt(mrg) * parseInt(disc) / 100;

        if(nomPot >= mrg){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Total potongan lebih besar dari nilai markup !!!",
                footer: ''
            });
        }

        $('#sale_price').val(saleP)
    })
</script>
@endsection