
@extends('layouts.app')

@section('template_title')
    Edit Plan Memberships 
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
                        <h3 class="nk-block-title page-title">Membership</h3>
                        <div class="nk-block-des text-soft">
                            <p>Edit Plan Membership</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown"><a href="#" class="dropdown-toggle btn btn-icon btn-primary"
                                        data-bs-toggle="dropdown"><em class="icon ni ni-minus"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a href="../membership" id="createNewPost">
                                                    <span>Cancel</span>
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
<form action="{{ url('update-member',$mber->id) }}" method='post'>
{{ csrf_field() }}
<div class="my-3 p-3 bg-body rounded shadow-sm">

    <div class="mb-3 row">
        <label for="name_membership" class="col-sm-2 col-form-label">Nama Plan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='name_membership' value="{{ $mber->name_membership }}" id="name_membership">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="limit_transaction" class="col-sm-2 col-form-label">Limit Transaction</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" name='limit_transaction' value="{{ $mber->limit_transaction }}" id="limit_transaction">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="submitmember" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10"><button type="submit" class="btn btn-primary" >SIMPAN</button></div>
    </div>
</div>
</form>

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