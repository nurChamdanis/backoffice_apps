@extends('layouts.app')

@section('template_title')
    Permission Roles
@endsection


@section('template_linked_css')
    @if (config('membership.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('membership.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .membership-table {
            border: 0;
        }

        .membership-table tr td:first-child {
            padding-left: 15px;
        }

        .membership-table tr td:last-child {
            padding-right: 15px;
        }

        .membership-table.table-responsive,
        .membership-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
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
                        <h3 class="nk-block-title page-title">Roles</h3>
                        <div class="nk-block-des text-soft">
                            <p>Settings Admin Roles</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                        data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="create-roles" id="createNewPost">
                                                    <span>Add New</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="nk-block">
                <div class="card card-stretch">

                    <div class="card-inner-group">

                        <div class="card-inner">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="30%">Role Name</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($roles as $key => $role)
                                    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $role->name }}</td>
                                        <td>

                                            <a style="background: #eddc58;border:none" class="btn btn-primary"
                                                href="edit-roles/{{ $role->id }}">
                                                <i class="icon dripicons-document-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>

                        </div>
                        <div class="card-footer">
                            {{isset($role->links) ? $role->links : null}}
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
@endsection
