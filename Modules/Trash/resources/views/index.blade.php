@extends('layouts.app')

@section('template_title')
    Trash
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
                    <h3 class="nk-block-title page-title">Data Trash</h3>
                    <div class="nk-block-des text-soft">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block">
            <div class="card card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <table id="tbl_trash" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>NAMA</th>
                                    <th>NO TLP</th>
                                    <th>EMAIL</th>
                                    <th>TYPE</th>
                                    <th>JOIN</th>
                                    <th>ACTION</th>
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
var table = $('#tbl_trash').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    responsive: true,
    ajax: "{{ route('list.user.trash') }}",
    columns: [
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
            data: 'type',
            name: 'type'
        },
        {
            data: 'join',
            name: 'join'
        },
        {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: true
        },
    ]
});

</script>
@endsection