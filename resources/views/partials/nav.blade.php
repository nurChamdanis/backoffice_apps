<div class="nk-header is-light nk-header-fixed is-light">
    <div class="container-xl wide-xxl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="/home" class="logo-link">
                    <img class="logo-light logo-img" src="{{logo()}}" srcset="{{logo()}} 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{logo()}}" srcset="{{logo()}} 2x" alt="logo-dark">
                </a>
            </div>

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    @php
                                        $n = allNotif();
                                    @endphp
                                    @foreach ($n as $item)
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon">
                                            @switch($item->type)
                                                @case('Topup')
                                                <em class="icon icon-circle bg-primary-dim ni ni-inbox-in"></em>
                                                @break

                                                @case('Transaksi')
                                                <em class="icon icon-circle bg-success-dim ni ni-cart"></em>
                                                @break

                                                @case('Disbursement')
                                                <em class="icon icon-circle bg-cyan-dim ni ni-wallet-out"></em>
                                                @break

                                                @case('Transfer')
                                                <em class="icon icon-circle bg-danger-dim ni ni-repeat-fill"></em>
                                                @break

                                                @case('Tukar Poin')
                                                <em class="icon icon-circle bg-info-dim ni ni-swap-alt"></em>
                                                @break

                                                @case('Tukar Koin')
                                                <em class="icon icon-circle bg-warning-dim ni ni-wallet-in"></em>
                                                @break
                                                    
                                            @endswitch
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">
                                                {{$item->content}}
                                            </div>
                                            <div class="nk-notification-time">
                                                {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="dropdown-foot center">
                                {{-- <a href="#">View All</a> --}}
                            </div>
                        </div>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">
                                            {{auth()->user()->name}}
                                        </span>
                                        <span class="sub-text">
                                            {{auth()->user()->email}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{url('v2/main-dashboard')}}/edit-operator/{{auth()->user()->id}}"><em class="icon ni ni-user-alt"></em><span>My Profile</span></a></li>
                                    <li><a href="{{ url('activity') }}"><em class="icon ni ni-activity-alt"></em><span>Log Activity</span></a></li>
                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{ route('logout') }}"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>