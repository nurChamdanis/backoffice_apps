@extends('layouts.app')

@section('template_title')
    Histori Poin
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
                        <h3 class="nk-block-title page-title">Data Histori Poin</h3>
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
            </div>
            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                </div>
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search"
                                                data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li>
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
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                            </div>>
                        </div>
                        <div class="card-inner">
                            <table id="tbl_opr" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>REF NO</th>
                                        <th>NAMA PENGGUNA</th>
                                        <th>NOMINAL</th>
                                        <th>JENIS</th>
                                        <th>KETERANGAN</th>
                                        <th>POIN AWAL</th>
                                        <th>POIN AKHIR</th>
                                        <th>TGL TRANSAKSI</th>
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
        var table = $('#tbl_opr').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            searching: false,
            ajax: {
                url: "{{ route('poin.list') }}",
                data: function(d) {
                    var status = [];
                    $("input[name='filterStatus']:checked").each(function() {
                        status.push($(this).attr("value"));
                    });
                    d.status = status
                    d.name = $("input[name='filterName']").val()
                    d.reference_code = $("input[name='filterReferenceCode']").val()
                    if ($("input[name='filterDateFrom']").val() != null &&
                        $("input[name='filterDateTo']").val() != null
                    ) {
                        d.date_range = [
                            $("input[name='filterDateFrom']").val(),
                            $("input[name='filterDateTo']").val(),
                        ]
                    }
                    console.log(d);
                }
            },
            columns: [{
                    data: 'ref_id',
                    name: 'ref_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'awal',
                    name: 'awal'
                },
                {
                    data: 'akhir',
                    name: 'akhir'
                },
                {
                    data: 'date',
                    name: 'date'
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
