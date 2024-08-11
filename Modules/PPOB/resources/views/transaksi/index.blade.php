@extends('layouts.app')

@section('template_title')
    Transaksi PPOB
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
                        <h3 class="nk-block-title page-title">Transaksi PPOB</h3>
                        <div class="nk-block-des text-soft">
                            <p>Data transaksi PPOB</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">

                        <div class="card-inner">
                            <table id="tbl_trx" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Pengguna</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Nomor Tujuan</th>
                                        <th>Harga Jual</th>
                                        {{-- <th>Markup</th> --}}
                                        {{-- <th>Total</th> --}}
                                        <th>SN/Serial Number</th>
                                        <th>Status</th>
                                        <th>Tgl Transaksi</th>
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
var tableTrx = $('#tbl_trx').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('trx-ppob.list') }}",
    columns: [
        {
            data: 'invoice',
            name: 'invoice'
        },
        {
            data: 'username',
            name: 'username'
        },
        {
            data: 'produk_id',
            name: 'produk_id'
        },
        {
            data: 'produk_name',
            name: 'produk_name'
        },
        {
            data: 'tujuan',
            name: 'tujuan'
        },
        {
            data: 'sale_price',
            name: 'sale_price'
        },
        // {
        //     data: 'margin',
        //     name: 'margin'
        // },
        // {
        //     data: 'total',
        //     name: 'total'
        // },
        {
            data: 'sn',
            name: 'sn'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'trx_date',
            name: 'trx_date'
        },
        {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
        },
    ]
});

$('#tbl_trx').on('click','.btn-delete',function(){
    var id = $(this).data('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        $.ajax({
            url: "{{ route('trx-ppob.delete') }}",
            type: 'POST',
            data: {_token: CSRF_TOKEN, id: id},
            success: function(response){
                if(response.success == 1){
                    tableTrx.ajax.reload();
                }else{
                    alert("Invalid ID.");
                }
            }
        });
    }
});


$('#tbl_trx').on('click','.btn-cek',function(e){
    
    var id = $(this).data('id');
    e.preventDefault();
    Swal.fire({
        title: "Cek Status Transaksi", 
        text: "Proses ini mungkin akan memakan waktu loading data", 
        icon: "question",
        showCancelButton: true,
        confirmButtonText: 'Cek'
    }).then(function (result) {
        if (result.value) {
            $(this).html('Sending..');

            $.ajax({
                data: {
                    seller_id : id,
                    _token: CSRF_TOKEN
                },
                url: "{{ route('trx-ppob.cek') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    NioApp.Toast(data[0].message, 'success', {
                        position: 'top-center'
                    });
                    table.draw();
                    Swal.close();
                    $('#savedata').html('Save Post');
                },
                error: function (data) {
                    Swal.close();
                    $('#savedata').html('Save Post');
                }
            });
        }
    });

});
</script>
@endsection
