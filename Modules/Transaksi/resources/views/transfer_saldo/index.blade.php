@extends('layouts.app')

@section('template_title')
    Transfer Saldo
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
                        <h3 class="nk-block-title page-title">Transfer Saldo</h3>
                        <div class="nk-block-des text-soft">
                            <p>Data history transfer saldo</p>
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
                                        <th>Kode Referensi</th>
                                        <th>Nama Pengguna</th>
                                        <th>Nominal Transfer</th>
                                        <th>Status</th>
                                        <th>Tgl Transaksi</th>
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
        var table = $('#tbl_trx').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            ajax: "{{ route('trf.saldo.list') }}",
            columns: [
                {
                    data: 'ref_id',
                    name: 'ref_id'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'trx_date',
                    name: 'trx_date'
                }
            ]
        });
    </script>
@endsection
