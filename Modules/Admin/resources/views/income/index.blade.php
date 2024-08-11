@extends('layouts.app')

@section('template_title')
    Income
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
                                <div class="card card-full bg-primary">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <em class="icon ni ni-wallet-in text-white fs-1"></em>
                                            </div>
                                            <h5 class="fs-3 text-white">
                                                Income Account
                                            </h5>
                                            <div>
                                                <span class="fs-12 text-white">income@bilpay.co.id</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-xxl-9">
                                <div class="card card-full bg-warning is-dark">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="fs-6 text-white text-opacity-75 mb-0">Income Value</div>
                                        </div>
                                        <h5 class="fs-1 text-white">
                                            {{rupiah($income)}}
                                        </h5>
                                        <div class="fs-7 text-white text-opacity-75 mt-1">
                                            <span class="text-white">Tanggal Data:  {{\Carbon\Carbon::parse($dateS)->format('d M Y')}} - {{\Carbon\Carbon::parse($dateE)->format('d M Y')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-gs mt-1">
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full" style="background-color: rgb(175, 235, 175)">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <img src="{{getOss('source/phpw5B73L.png')}}" alt="lg_nukar" width="50px" srcset="">
                                            </div>
                                            <h5 class="fs-3 text-black">
                                                {{rupiah($nukar)}}
                                            </h5>
                                            <div>
                                                <span class="fs-12 text-black">
                                                    Sisa saldo NUKAR - bilpay@gmail.com
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-3">
                                <div class="card card-full" style="background-color: rgb(240, 165, 137)">
                                    <div class="card-inner">
                                        <div class="">
                                            <div>
                                                <img src="https://klick.id/images/SVG-COLOR-SINGLE.svg" alt="lg-klick" width="50px">
                                            </div>
                                            <h5 class="fs-3 text-black">
                                                {{rupiah($klik)}}
                                            </h5>
                                            <div>
                                                <span class="fs-12 text-black">
                                                    Sisa saldo KLICK - bilpay.id@gmail.com
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

                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                </div>
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <div class="toggle-wrap">
                                                <a href="#" class="btn btn-icon btn-trigger toggle"
                                                    data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                <div class="toggle-content" data-content="cardTools">
                                                    <ul class="btn-toolbar gx-1">
                                                        
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
                                                                                <div class="col-126">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="overline-title overline-title-alt"
                                                                                            for="default-01">Nama Produk</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="filterName">
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
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

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
            ajax: {
                url: "{{ route('income.list') }}",
                data: function(d) {
                    
                    d.name = $("input[name='filterName']").val()
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
