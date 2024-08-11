
@extends('layouts.app')

@section('template_title')
    Edit My Profile
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
 <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-xl">
                        <div class="nk-content-body">
                            <div class="nk-block">
                                <div class="card">
                                    <div class="card-aside-wrap">
                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-block-head nk-block-head-lg">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h4 class="nk-block-title">Personal Information</h4>
                                                        <div class="nk-block-des">
                                                            <p>Ubah Informasi Pribadi dan Kredensial akun anda lalu klik tombol Save.</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
<form action="{{ url('v2/main-dashboard/update-operator',$mber->id) }}" method='post'>
        {{ csrf_field() }}
                                            <div class="nk-block">
                                                <div class="nk-data data-list">
                                                    <div class="data-head">
                                                        <h6 class="overline-title">Basics</h6>
                                                    </div>
                                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                        <div class="data-col">
                                                            <span class="data-label">Full Name</span>
            <input type="text" class="form-control" name='name' placeholder="masukkan nama" value="{{auth()->user()->name}}" id="name">
                                                        </div>
                                                    </div><!-- data-item -->
                                                    
                                                   <div class="data-item">
                                                        <div class="data-col">
                                                            <span class="data-label">Phone</span>
            <input type="number" class="form-control" placeholder="masukkan Nomer Handphone" name='phone' value="{{auth()->user()->phone}}" id="phone"  required="required">
                                                        </div>
                                                    </div><!-- data-item -->
                                                    <div class="data-item">
                                                        <div class="data-col">
                                                            <span class="data-label">Email</span>
            <input type="email" class="form-control" placeholder="masukkan email" name='email' value="{{auth()->user()->email}}" id="email"  required="required">
                                                        </div>
                                                    </div><!-- data-item -->
                                                   <div class="data-item">
                                                        <div class="data-col">
                                                            <span class="data-label">Password</span>
            <input type="password" class="form-control" placeholder="masukkan password" onfocus="this. value=''" name='password' value="{{auth()->user()->password}}" id="password" required="required">
                                                        </div>
                                                    </div><!-- data-item -->

                                                   <div class="data-item">
                                                        <div class="data-col">

        <div class="col-sm-10"><button type="submit" class="btn btn-primary" >SIMPAN</button></div>
                                                        </div>
                                                    </div>
                                                </div><!-- data-list -->
                                              
                                                </form>
                                            </div><!-- .nk-block -->
                                        </div>
                                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card">
                                                        <div class="user-avatar bg-primary">
                                                            <span>AB</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text"> {{auth()->user()->name}}</span>
                                                            <span class="sub-text"> {{auth()->user()->email}}</span>
                                                        </div>
                                                        <div class="user-action">
                                                            <div class="dropdown">
                                                                <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                                        <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .user-card -->
                                                </div><!-- .card-inner -->
                                                {{----<div class="card-inner">
                                                    <div class="user-account-info py-0">
                                                        <h6 class="overline-title-alt">Nio Wallet Account</h6>
                                                        <div class="user-balance">12.395769 <small class="currency currency-btc">BTC</small></div>
                                                        <div class="user-balance-sub">Locked <span>0.344939 <span class="currency currency-btc">BTC</span></span></div>
                                                    </div>
                                                </div><!-- .card-inner -->----}}
            
                                            </div><!-- .card-inner-group -->
                                        </div><!-- card-aside -->
                                    </div><!-- .card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
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