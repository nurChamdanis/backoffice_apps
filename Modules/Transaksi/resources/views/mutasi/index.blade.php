@extends('layouts.app')

@section('template_title')
    Mutasi Transaksi
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
                        <h3 class="nk-block-title page-title">Aktifitas Finansial Pengguna</h3>
                        <div class="nk-block-des text-soft">
                            <p>Data aktifitas keuangan pengguna</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalExport">
                                    Export Excel
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="modal fade" tabindex="-1" id="modalExport">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Export Data</h5>
                                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <em class="icon ni ni-cross"></em>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <span>
                                            Simpan data export ini dengan baik, data akan di refresh setiap 3 bulan
                                        </span>
                                    </div>
                                    <form action="{{ route('export.mutasi') }}" method="POST" class="form-horizontal">
                                        @csrf

                                        {{-- <div class="form-group">
                                            <label class="form-label">Filter Tanggal</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group">
                                                    <input type="text" name="start" class="form-control" />
                                                    <div class="input-group-addon">TO</div>
                                                    <input type="text" name="end" class="form-control" />
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                Get Data
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                Batal
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
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                </div><!-- .card-tools -->
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li><!-- li -->
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle"
                                                    data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        <li class="toggle-close">
                                                            <a href="#" class="btn btn-icon btn-trigger toggle"
                                                                data-target="cardTools"><em
                                                                    class="icon ni ni-arrow-left"></em></a>
                                                        </li>
                                                        <li>
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="btn btn-trigger btn-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-filter-alt"></em>
                                                                </a>
                                                                <div
                                                                    class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                                    <div class="dropdown-head">
                                                                        <span class="sub-title dropdown-title">Filter</span>
                                                                    </div>
                                                                    <div class="dropdown-body dropdown-body-rg">
                                                                        <form name="formFilter">
                                                                            <div class="row gx-6 gy-3">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt">Status</label>
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <ul
                                                                                                    class="custom-control-group">
                                                                                                    <li>
                                                                                                        <div
                                                                                                            class="custom-control custom-checkbox custom-control-pro no-control">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                class="custom-control-input"
                                                                                                                name="filterStatus"
                                                                                                                id="filterStatusInquiry"
                                                                                                                value="INQUIRY">
                                                                                                            <label
                                                                                                                class="custom-control-label"
                                                                                                                for="filterStatusInquiry">INQUIRY</label>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div
                                                                                                            class="custom-control custom-checkbox custom-control-pro no-control">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                class="custom-control-input"
                                                                                                                name="filterStatus"
                                                                                                                id="filterStatusSuccess"
                                                                                                                value="SUCCESS">
                                                                                                            <label
                                                                                                                class="custom-control-label"
                                                                                                                for="filterStatusSuccess">SUCCESS</label>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div
                                                                                                            class="custom-control custom-checkbox custom-control-pro no-control">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                class="custom-control-input"
                                                                                                                name="filterStatus"
                                                                                                                id="filterStatusFailed"
                                                                                                                value="FAILED">
                                                                                                            <label
                                                                                                                class="custom-control-label"
                                                                                                                for="filterStatusFailed">FAILED</label>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <div
                                                                                                            class="custom-control custom-checkbox custom-control-pro no-control">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                class="custom-control-input"
                                                                                                                name="filterStatus"
                                                                                                                id="filterStatusPending"
                                                                                                                value="PENDING">
                                                                                                            <label
                                                                                                                class="custom-control-label"
                                                                                                                for="filterStatusPending">PENDING</label>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt"
                                                                                            for="default-01">Name</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="filterName">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt"
                                                                                            for="default-01">Reference
                                                                                            Code</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="filterReferenceCode">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt">Transaction
                                                                                            Date</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control date-picker"
                                                                                                    placeholder="From"
                                                                                                    name="filterDateFrom"
                                                                                                    data-date-format="dd-mm-yyyy" />
                                                                                                <div
                                                                                                    class="input-group-addon">
                                                                                                    ~</div>
                                                                                                <input type="text"
                                                                                                    id="filterDaterange"
                                                                                                    class="form-control date-picker"
                                                                                                    name="filterDateTo"
                                                                                                    data-date-format="dd-mm-yyyy"
                                                                                                    placeholder="To" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="dropdown-foot between">
                                                                        <a class="clickable" id="filterReset"
                                                                            href="#">Reset
                                                                            Filter</a>
                                                                        <div class="form-group">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                id="filterSubmit">Filter</button>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- .filter-wg -->
                                                            </div><!-- .dropdown -->
                                                        </li><!-- li -->
                                                    </ul><!-- .btn-toolbar -->
                                                </div><!-- .toggle-content -->
                                            </div><!-- .toggle-wrap -->
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search"
                                            data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none"
                                            placeholder="Search" name="keyword">
                                        <button id="searchSubmit" class="search-submit btn btn-icon"><em
                                                class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->
                        <div class="card-inner">
                            <table id="tbl_trx" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>REF NO/TANGGAL</th>
                                        <th>SUMBER</th>
                                        <th>CASH IN/OUT TUJUAN</th>
                                        <th>NOMINAL</th>
                                        <th>JENIS TRANSAKSI</th>
                                        <th>STATUS</th>
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
            searching: false,
            ajax: {
                url: "{{ route('mutation-history.list') }}",
                data: function(d) {
                    var status = [];
                    $("input[name='filterStatus']:checked").each(function() {
                        status.push($(this).attr("value"));
                    });
                    d.status = status
                    d.name = $("input[name='filterName']").val()
                    d.keyword = $("input[name='keyword']").val()
                    d.reference_code = $("input[name='filterReferenceCode']").val()
                    if ($("input[name='filterDateFrom']").val() != null &&
                        $("input[name='filterDateTo']").val() != null
                    ) {
                        d.date_range = [
                            $("input[name='filterDateFrom']").val(),
                            $("input[name='filterDateTo']").val(),
                        ]
                    }
                }
            },
            columns: [{
                    data: 'ref_id',
                    name: 'ref_id'
                },
                {
                    data: 'sumber',
                    name: 'sumber'
                },
                {
                    data: 'tujuan',
                    name: 'tujuan'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ]
        });

        $("#filterSubmit").click(function(e) {
            e.preventDefault();
            table.draw()
        })
        $("#searchSubmit").click(function(e) {
            e.preventDefault();
            table.draw()
        })
        $("#filterReset").click(function(e) {
            e.preventDefault();
            $("form[name='formFilter']")[0].reset()
            table.draw()
        })
    </script>
@endsection
