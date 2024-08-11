@extends('layouts.app')

@section('template_title')
    Supplier
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
                        <div class="nk-block-des text-soft">
                            <p></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-dark">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <div class="fs-6 text-white text-opacity-75 mb-0">
                                                    Supplier PPOB
                                                </div>
                                                <h5 class="fs-3 text-white">
                                                    NUKAR : 
                                                </h5>
                                            </div>
                                            <div>
                                                <span class="fs-12 text-white">
                                                    bilpay@gmail.com
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-warning">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <div class="fs-6 text-white text-opacity-75 mb-0">
                                                    Instan Transfer
                                                </div>
                                                <h5 class="fs-3 text-white">
                                                    KLICK : 
                                                </h5>
                                            </div>
                                            <div>
                                                <span class="fs-12 text-white">
                                                    powered by: ayoconnect.id
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full bg-info">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <div class="fs-6 text-white text-opacity-75 mb-0">
                                                    Payment Gateway
                                                </div>
                                                <h5 class="fs-3 text-white">
                                                    KLICK : 
                                                </h5>
                                            </div>
                                            <div>
                                                <span class="fs-12 text-white">
                                                    powered by: linkqu.id
                                                </span>
                                            </div>
                                        </div>
                                    </div>
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
                            <table id="tbl_income" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>REF NO</th>
                                        <th>PRODUK ID</th>
                                        <th>VALUE</th>
                                        <th>TIPE</th>
                                        <th>POSTED</th>
                                        <th>TANGGAL</th>
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
        var table = $('#tbl_income').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            ajax: "{{ route('income.list') }}",
            columns: [
                {
                    data: 'ref_id',
                    name: 'ref_id'
                },
                {
                    data: 'produk_id',
                    name: 'produk_id'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'posted',
                    name: 'posted'
                },
                {
                    data: 'date',
                    name: 'date'
                }
            ]
        });
    </script>
@endsection
