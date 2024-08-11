@extends('layouts.app')

@section('template_title')
    All Member's
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
                        <h3 class="nk-block-title page-title">All Member Registered</h3>
                        <div class="nk-block-des text-soft">
                            <p></p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalExport">
                                    Export Excel
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Import Excel -->
                    <div class="modal fade" id="modalDefault" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="{{route('member.import')}}" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Import Excel</h5>
                                    </div>
                                    <div class="modal-body">
                                        {{ csrf_field() }}

                                        <label>Pilih file Excel</label>
                                        <div class="form-group">
                                            <input type="file" name="file" required="required">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="modalCreate" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="postForm" name="postForm" class="form-horizontal"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="name" class="control-label">Nama Lengkap</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="control-label">Nomor Tlp</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="control-label">Alamat Email</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="savedata"
                                                value="create">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalBalance" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="{{route('member.importBalance')}}" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Import Excel</h5>
                                    </div>
                                    <div class="modal-body">
                                        {{ csrf_field() }}

                                        <label>Pilih file Excel</label>
                                        <div class="form-group">
                                            <input type="file" name="file" required="required">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" tabindex="-1" id="modalExport">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Export Data</h5>
                                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                        <em class="icon ni ni-cross"></em>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <span>
                                            Simpan data export ini dengan baik, data akan di refresh setiap 3 bulan
                                        </span>
                                    </div>
                                    <form action="{{ route('export.users') }}" method="POST" class="form-horizontal">
                                        @csrf
                
                                        <div class="form-group"> 
                                            <label class="form-label">Filter Tanggal</label>
                                            <div class="form-control-wrap">
                                                <div class="input-daterange date-picker-range input-group"> 
                                                    <input type="text" name="start" class="form-control" />
                                                    <div class="input-group-addon">TO</div> 
                                                    <input type="text" name="end" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">
                                                Get Data
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-gs mt-1">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="card card-full" style="background-color: rgb(88, 86, 192)">
                            <div class="card-inner">
                                <div class="">
                                    <h5 class="fs-3 text-white">
                                        {{rupiah($saldo)}}
                                    </h5>
                                    <div>
                                        <span class="fs-12 text-white">
                                            Saldo Member
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="card card-full" style="background-color: rgb(201, 126, 13)">
                            <div class="card-inner">
                                <div class="">
                                    <h5 class="fs-3 text-white">
                                        {{rupiah($poin)}}
                                    </h5>
                                    <div>
                                        <span class="fs-12 text-white">
                                            Total Poin
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="card card-full" style="background-color: rgb(233, 70, 70)">
                            <div class="card-inner">
                                <div class="">
                                    <h5 class="fs-3 text-white">
                                        {{rupiah($koin)}}
                                    </h5>
                                    <div>
                                        <span class="fs-12 text-white">
                                            Total Koin
                                        </span>
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
                            <table id="tbl_user" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode Ref</th>
                                        {{-- <th>Member ID</th> --}}
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Saldo</th>
                                        <th>Poin</th>
                                        <th>Koin</th>
                                        <th>KYC</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Join</th>
                                        {{-- <th>Last Login</th> --}}
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
        var table = $('#tbl_user').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            ajax: "{{ route('member.user') }}",
            columns: [
                {
                    data: 'code',
                    name: 'code'
                },
                // {
                //     data: 'card',
                //     name: 'card'
                // },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },
                {
                    data: 'poin',
                    name: 'poin'
                },
                {
                    data: 'koin',
                    name: 'koin'
                },
                {
                    data: 'kyc',
                    name: 'kyc'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'join',
                    name: 'join'
                },
                // {
                //     data: 'last_login',
                //     name: 'last_login'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $('#createNewPost').click(function() {
            $('#savedata').val("create-post");
            $('#id').val('');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Tambah Data Member");
            $('#modalCreate').modal('show');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#postForm').serialize(),
                url: "{{ route('members.store') }}",
                method: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#postForm').trigger("reset");
                    $('#modalCreate').modal('hide');
                    NioApp.Toast(data[0].message, 'success', {
                        position: 'top-center'
                    });
                    table.draw();

                },
                error: function(data) {
                    $('#savedata').html('Save Changes');
                }
            });
        });

        $('#tbl_user').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var deleteConfirm = confirm("Are you sure?");
            if (deleteConfirm == true) {
                $.ajax({
                    url: "{{ route('member.delete') }}",
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(response) {
                        if (response.success == 1) {
                            table.ajax.reload();
                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            }
        });
    </script>
@endsection
