<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Dashboard Analytics,
                            <small>{{ Auth::user()->name }}</small></h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <a href="#"
                                            class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                            data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em><span><span
                                                    class="d-md-none">Add</span><span
                                                    class="d-none d-md-block">Broadcast Pengumuman</span></span></a>
                                    </li>
                                    <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em
                                                class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 bg-primary">
                            <div class="nk-cmwg nk-cmwg1">
                                <div class="card-inner pt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-item">
                                            <div class="text-white d-flex flex-wrap">
                                                <span class="fs-2 me-1">


                                                    <!-- Wherever you want to display the value -->
                                                    <div id="jumlahuser"></div>
                                                </span>
                                            </div>
                                            <h6 class="text-white" id="txt2">User Mendaftar</h6>
                                        </div>
                                        <div class="card-tools me-n1">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-sm btn-trigger on-dark"
                                                    data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" class="active"><span>15 Days</span></a>
                                                        </li>
                                                        <li><a href="#"><span>30 Days</span></a></li>
                                                        <li><a href="#"><span>3 Months</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="nk-ck-wrap mt-auto overflow-hidden rounded-bottom">
                                    <div class="nk-cmwg1-ck">
                                        <!-- Place where the chart will be displayed -->

                                        <canvas id="lineChart"></canvas>


                                    </div>
                                </div>
                            </div><!-- .nk-cmwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 bg-info">
                            <div class="nk-cmwg nk-cmwg1">
                                <div class="card-inner pt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-item">
                                            <div class="text-white d-flex flex-wrap">
                                                <span class="fs-2 me-1">
                                                    <div id="jumlahtrans"></div>
                                                </span>
                                            </div>
                                            <h6 class="text-white" id="txt2">Transaksi Harian</h6>
                                        </div>
                                        <div class="card-tools me-n1">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-sm btn-trigger on-dark"
                                                    data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="nk-cmwg1-ck mt-auto">
                                    <canvas id="hariChart"></canvas>
                                </div>
                            </div><!-- .nk-cmwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 bg-warning">
                            <div class="nk-cmwg nk-cmwg1">
                                <div class="card-inner pt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-item">
                                            <div class="text-white d-flex flex-wrap">
                                                <span class="fs-2 me-1">
                                                    <div id="jumlahdeposit"></div>
                                                </span>
                                            </div>
                                            <h6 class="text-white" id="txt2">Topup Harian</h6>
                                        </div>
                                        <div class="card-tools me-n1">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-sm btn-trigger on-dark"
                                                    data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="nk-ck-wrap mt-auto overflow-hidden rounded-bottom">
                                    <div class="nk-cmwg1-ck">
                                        <canvas id="depositChart"></canvas>
                                    </div>
                                </div>
                            </div><!-- .nk-cmwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 bg-danger">
                            <div class="nk-cmwg nk-cmwg1">
                                <div class="card-inner pt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-item">
                                            <div class="text-white d-flex flex-wrap">
                                                <span class="fs-2 me-1">
                                                    <div id="jumlahproduk"></div>
                                                </span>
                                            </div>
                                            <h6 class="text-white" id="txt2">Total Produk</h6>
                                        </div>
                                        <div class="card-tools me-n1">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-sm btn-trigger on-dark"
                                                    data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="nk-ck-wrap mt-auto overflow-hidden rounded-bottom">
                                    <div class="nk-cmwg1-ck">
                                        <canvas id="produkChart"></canvas>
                                    </div>
                                </div>
                            </div><!-- .nk-cmwg -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xxl-8 col-lg-7">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Top Product Margin</h6>
                                    </div>
                                    <div class="card-tools">
                                        <ul class="card-tools-nav">
                                            <li class="active"><a href="#"><span>Monthly</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-inner pt-0">
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
                                <canvas id="pieChart" width="100%" height="auto"></canvas>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $.getJSON('{{ route('pieChart') }}', function(data) {
                                            var ctx = document.getElementById('pieChart').getContext('2d');

                                            var chart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: data.map(item => item.produk),
                                                    datasets: [{
                                                        label: 'Total Margin',
                                                        data: data.map(item => item.margin),
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.7)',
                                                            'rgba(54, 162, 235, 0.7)',
                                                            'rgba(255, 206, 86, 0.7)',
                                                            // Add more colors if needed
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    // Additional options for the chart
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </div>



                        </div><!-- .card -->

                    </div><!-- .col -->

                    <div class="col-xxl-4 col-lg-5">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Top 10 Transaksi</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('trx.ppob.index') }}" class="link">View All Transaksi</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner pt-0">
                                <ul class="gy-4">
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $.ajax({
                                                url: '/showData', // Replace with the route for JSON data
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    $.each(data, function(index, item) {
                                                        $('#your-list').append(
                                                            '<li class="justify-between align-center border-bottom border-0 border-dashed"><div class="align-center" ><div class="ms-2"><div class="lead-text">Produk: ' +
                                                            item.produk_id +
                                                            ' <div class="sub-text">Tujuan: ' +
                                                            item.tujuan +
                                                            '</div></div></div></div><div class="align-center"><div class="sub-text me-2">Harga: ' +
                                                            item.harga +
                                                            '</div></li>'
                                                        );
                                                    });
                                                }
                                            });
                                        });
                                    </script>

                                    <li id="your-list"> </li>

                                    <noscript>
                                        <li class="justify-between align-center border-bottom border-0 border-dashed">
                                            <div class="align-center">
                                                <div class="user-avatar sq bg-transparent"><img
                                                        src="./images/icons/campaign/brand/instagram.png"
                                                        alt=""></div>
                                                <div class="ms-2">
                                                    <div class="lead-text">Instagram </div>
                                                    <div class="sub-text">Social Media</div>
                                                </div>
                                            </div>
                                            <div class="align-center">
                                                <div class="sub-text me-2">86%</div>
                                                <div class="progress rounded-pill w-80px">
                                                    <div class="progress-bar bg-primary rounded-pill"
                                                        data-progress="86"></div>
                                                </div>
                                            </div>
                                        </li>
                                    </noscript>
                                    <!-- li -->

                                </ul>

                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->



                    <div class="col-xxl-6 col-lg-6">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Top 10 Produk Terlaris</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('menu.index') }}" class="link">View All Produk</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner pt-0">
                                <ul class="gy-4">

                                    <script>
                                        $(document).ready(function() {
                                            $.ajax({
                                                url: '/produkData', // Replace with the route for JSON data
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(nata) {
                                                    $.each(nata, function(index, item) {
                                                        $('#your-produk').append(
                                                            '<li class="justify-between align-center border-bottom border-0 border-dashed"><div class="align-center" ><div class="ms-2"><div class="lead-text">' +
                                                            item.produk_id + '-' + item.name +
                                                            ' <div class="sub-text">Harga: ' +
                                                            item.harga +
                                                            '</div></div></div></div><div class="align-center"><div class="sub-text me-2">Total Sales: ' +
                                                            item.total +
                                                            '</div></li>'
                                                        );
                                                    });
                                                }
                                            });
                                        });
                                    </script>

                                    <li id="your-produk"> </li>


                                </ul>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->


                    <div class="col-xxl-6 col-lg-6">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Top 10 User</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('members.index') }}" class="link">View All User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner pt-0">
                                <ul class="gy-4">
                                    <script>
                                        $(document).ready(function() {
                                            $.ajax({
                                                url: '/userData', // Replace with the route for JSON data
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(unata) {
                                                    $.each(unata, function(index, item) {
                                                        $('#your-user').append(
                                                            '<li class="justify-between align-center border-bottom border-0 border-dashed"><div class="align-center" ><div class="ms-2"><div class="lead-text">' +
                                                            item.name +
                                                            ' <div class="sub-text">Email: ' +
                                                            item.email +
                                                            '</div></div></div></div><div class="align-center"><div class="sub-text me-2">Order: ' +
                                                            item.total +
                                                            '</div></li>'
                                                        );
                                                    });
                                                }
                                            });
                                        });
                                    </script>

                                    <li id="your-user"> </li>
                                </ul>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <!--end top-->

                    <div class="col-xxl-8 col-lg-7">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Performa Penjualan Bulanan</h6>
                                    </div>
                                    <div class="card-tools me-n1 mt-n1">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Tahunan</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner pt-0">
                                <script src="https://code.highcharts.com/highcharts.js"></script>

                                <script>
                                    $(document).ready(function() {
                                        $.getJSON('/salesChart', function(data) { // Replace with your route name
                                            var chart = Highcharts.chart('aspo', data);
                                        });
                                    });
                                </script>

                                <div id="aspo"></div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->

                    <div class="col-xxl-4 col-lg-5">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Status Server PPOB</h6>
                                    </div>
                                    <div class="card-tools me-n1 mt-n1">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" class="active"><span>15 Days</span></a></li>
                                                    <li><a href="#"><span>30 Days</span></a></li>
                                                    <li><a href="#"><span>3 Months</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner pt-0">
                                <div class="">
                                    <span class="fs-2 lh-1 mb-1 text-head">3.86%</span>
                                    <div class="fs-14px">This month</div>
                                </div>
                                <div class="nk-cmwg4-ck mt-4">
                                </div>
                                <div class="chart-label-group ms-5 mt-0">
                                    <div class="chart-label">Jan</div>
                                    <div class="chart-label d-none d-sm-block">Feb</div>
                                    <div class="chart-label d-none d-sm-block">Mar</div>
                                    <div class="chart-label d-none d-sm-block">Apr</div>
                                    <div class="chart-label d-none d-sm-block">May</div>
                                    <div class="chart-label">Jun</div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xxl-8">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Ringkasan Transaksi Topup Saldo</h6>
                                    </div>

                                    <div class="card-tools">
                                        <a href="#" class="link">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner py-0 mt-n2">
                                <div class="nk-tb-list nk-tb-flush nk-tb-dashed">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>Subject</span></div>
                                        <div class="nk-tb-col tb-col-mb"><span>Channels</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Status</span></div>
                                        <div class="nk-tb-col tb-col-md"><span>Assignee</span></div>
                                        <div class="nk-tb-col text-end"><span>Date Range</span></div>
                                    </div><!-- .nk-tb-head -->
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead">Happy Christmas <span
                                                    class="dot dot-success d-sm-none ms-1"></span></span>
                                            <span class="tb-sub">Created on 01 Dec 22</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-mb">
                                            <ul class="d-flex gx-1">
                                                <li class="text-facebook"><em class="icon ni ni-facebook-f"></em></li>
                                                <li class="text-instagram"><em class="icon ni ni-instagram"></em></li>
                                                <li class="text-linkedin"><em class="icon ni ni-linkedin"></em></li>
                                                <li class="text-twitter"><em class="icon ni ni-twitter"></em></li>
                                                <li class="text-youtube"><em class="icon ni ni-youtube-fill"></em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="badge badge-dim bg-success">Live Now</div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-avatar-group">
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/e-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/f-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/g-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <span>2+</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end"><span>01 Dec - 07 Dec</span></div>
                                    </div><!-- .nk-tb-item -->
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead">Black Friday <span
                                                    class="dot dot-success d-sm-none ms-1"></span></span>
                                            <span class="tb-sub">Created on 01 Dec 22</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-mb">
                                            <ul class="d-flex gx-1">
                                                <li class="text-linkedin"><em class="icon ni ni-linkedin"></em></li>
                                                <li class="text-facebook"><em class="icon ni ni-facebook-f"></em></li>
                                                <li class="text-instagram"><em class="icon ni ni-instagram"></em></li>
                                                <li class="text-youtube"><em class="icon ni ni-youtube-fill"></em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="badge badge-dim bg-success">Live Now</div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-avatar-group">
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/h-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/i-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/j-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <span>7+</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end"><span>01 Dec - 07 Dec</span></div>
                                    </div><!-- .nk-tb-item -->
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead">Tree Plantation <span
                                                    class="dot dot-warning d-sm-none ms-1"></span></span>
                                            <span class="tb-sub">Created on 01 Jan 23</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-mb">
                                            <ul class="d-flex gx-1">
                                                <li class="text-twitter"><em class="icon ni ni-twitter"></em></li>
                                                <li class="text-instagram"><em class="icon ni ni-instagram"></em></li>
                                                <li class="text-linkedin"><em class="icon ni ni-linkedin"></em></li>
                                            </ul>
                                        </div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="badge badge-dim bg-warning">Paused</div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-avatar-group">
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/k-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs bg-pink">
                                                    <span>AE</span>
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/e-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <span>3+</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end"><span>01 Dec - 07 Dec</span></div>
                                    </div><!-- .nk-tb-item -->
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span class="tb-lead">Getaway Trailer <span
                                                    class="dot dot-success d-sm-none ms-1"></span></span>
                                            <span class="tb-sub">Created on 12 Dec 22</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-mb">
                                            <ul class="d-flex gx-1">
                                                <li class="text-linkedin"><em class="icon ni ni-linkedin"></em></li>
                                                <li class="text-twitter"><em class="icon ni ni-twitter"></em></li>
                                                <li class="text-facebook"><em class="icon ni ni-facebook-f"></em></li>
                                                <li class="text-youtube"><em class="icon ni ni-youtube-fill"></em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nk-tb-col tb-col-sm">
                                            <div class="badge badge-dim bg-success">Live Now</div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="user-avatar-group">
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/i-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/k-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/e-sm.jpg" alt="">
                                                </div>
                                                <div class="user-avatar xs">
                                                    <img src="./images/avatar/g-sm.jpg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end"><span>01 Dec - 07 Dec</span></div>
                                    </div><!-- .nk-tb-item -->
                                </div><!-- .nk-tb-list -->
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->

                </div><!-- .row -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
<!-- content @e -->


@section('js')
    <!---User Register Chart-->
    <script>
        $(document).ready(function() {
            $.get('{{ route('regUser') }}').then((response) => {
                var jumlahuser = response[0].jumlah;
                // Display the value wherever you want in your view
                $('#jumlahuser').text(jumlahuser);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.get('{{ route('regChart') }}').then((response) => {
                var labelsing = response.labels;
                var datasing = response.data;

                // Create chart
                createChart(labelsing, datasing);
            });
        });

        function createChart(labels, data) {
            var ctx = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "People",
                        data: data,
                        borderColor: "#fff",
                        backgroundColor: 'rgba(255, 255, 255, 0.85)',
                        borderWidth: 1,
                        lineTension: 0.5, // Adjust smoothness of the line
                        borderCapStyle: 'round'

                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Hide x-axis
                        },
                        y: {
                            display: false // Hide y-axis
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        },
                        tooltip: {
                            enabled: true // Disable tooltip
                        }
                    }
                }
            });
        }
    </script>
    <!---Trans Harian Chart-->
    <script>
        $(document).ready(function() {
            $.get('{{ route('transUser') }}').then((response) => {
                var jumlahtrans = response[0].jumlah;
                // Display the value wherever you want in your view
                $('#jumlahtrans').text(jumlahtrans);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.get('{{ route('harianChart') }}').then((response) => {
                var harianlabels = response.harianlabels;
                var hariandata = response.hariandata;

                // Create chart
                createharianChart(harianlabels, hariandata);
            });
        });

        function createharianChart(harianlabels, hariandata) {
            var cth = document.getElementById('hariChart').getContext('2d');
            var hariChart = new Chart(cth, {
                type: 'line',
                data: {
                    labels: harianlabels,
                    datasets: [{
                        label: "Order",
                        data: hariandata,
                        borderColor: "#fff",
                        backgroundColor: 'rgba(255, 255, 255, 0.85)',
                        borderWidth: 1,
                        lineTension: 0.5, // Adjust smoothness of the line
                        borderCapStyle: 'round'

                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Hide x-axis
                        },
                        y: {
                            display: false // Hide y-axis
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        },
                        tooltip: {
                            enabled: true // Disable tooltip
                        }
                    }
                }
            });
        }
    </script>
    <!---Topup Chart-->
    <script>
        $(document).ready(function() {
            $.get('{{ route('depositUser') }}').then((response) => {
                var jumlahdeposit = response[0].jumlah;
                // Display the value wherever you want in your view
                $('#jumlahdeposit').text(jumlahdeposit);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.get('{{ route('depositChart') }}').then((response) => {
                var depositlabels = response.depositlabels;
                var depositdata = response.depositdata;

                // Create chart
                createdepoChart(depositlabels, depositdata);
            });
        });

        function createdepoChart(depositlabels, depositdata) {
            var cth = document.getElementById('depositChart').getContext('2d');
            var depositChart = new Chart(cth, {
                type: 'line',
                data: {
                    labels: depositlabels,
                    datasets: [{
                        label: "Topup",
                        data: depositdata,
                        borderColor: "#fff",
                        backgroundColor: 'rgba(255, 255, 255, 0.85)',
                        borderWidth: 1,
                        lineTension: 0.5, // Adjust smoothness of the line
                        borderCapStyle: 'round'

                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Hide x-axis
                        },
                        y: {
                            display: false // Hide y-axis
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        },
                        tooltip: {
                            enabled: true // Disable tooltip
                        }
                    }
                }
            });
        }
    </script>
    <!---Produk Chart-->
    <script>
        $(document).ready(function() {
            $.get('{{ route('produkUser') }}').then((response) => {
                var jumlahproduk = response[0].jumlah;
                // Display the value wherever you want in your view
                $('#jumlahproduk').text(jumlahproduk);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.get('{{ route('produkChart') }}').then((response) => {
                var produklabels = response.produklabels;
                var produkdata = response.produkdata;

                // Create chart
                createprodukChart(produklabels, produkdata);
            });
        });

        function createprodukChart(produklabels, produkdata) {
            var cth = document.getElementById('produkChart').getContext('2d');
            var produkChart = new Chart(cth, {
                type: 'line',
                data: {
                    labels: produklabels,
                    datasets: [{
                        label: "Topup",
                        data: produkdata,
                        borderColor: "#fff",
                        backgroundColor: 'rgba(255, 255, 255, 0.85)',
                        borderWidth: 1,
                        lineTension: 0.5, // Adjust smoothness of the line
                        borderCapStyle: 'round'

                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Hide x-axis
                        },
                        y: {
                            display: false // Hide y-axis
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        },
                        tooltip: {
                            enabled: true // Disable tooltip
                        }
                    }
                }
            });
        }
    </script>
@endsection
