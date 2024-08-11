<div class="nk-sidebar is-light nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{ url('home') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ logo() }}" srcset="{{ logo() }} 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{ logo() }}" srcset="{{ logo() }} 2x"
                    alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{ logo() }}"
                    srcset="{{ logo() }} 2x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
        </div>
    </div>
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Dashboards</h6>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ url('home') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-users"></em>
                            </span>
                            <span class="nk-menu-text">User Management</span>
                        </a>

                        <ul class="nk-menu-sub">


                    @if (Auth::check() && Auth::user()->activated == 1 )
                            <li class="nk-menu-item">
                                <a href="{{ route('users::user') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">User Registered</span>
                                </a>
                            </li>
                            @else

                            <li class="nk-menu-item">
                                <a href="{{ route('members.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">User Registered</span>
                                </a>
                            </li>
                            @endif
                    @if (Auth::check() && Auth::user()->activated == 1 || Auth::user()->activated == 2)
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link">
                                    <span class="nk-menu-text">e-KYC Users</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('admins.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Operator</span>
                                </a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="{{ route('laravelroles::roles.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Role & Permission Akses</span>
                                </a>
                            </li> --}}
							 <li class="nk-menu-item">
                                <a href="/admin-roles" class="nk-menu-link">
                                    <span class="nk-menu-text">Role & Permission Operator</span>
                                </a>
                            </li> 

                     @endif
                           {{--  <li class="nk-menu-item">
                                <a href="/permissions-roles" class="nk-menu-link">
                                    <span class="nk-menu-text">Permission Akses</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin')))
                   @endif

                    @if (Auth::check() && Auth::user()->activated == 1 || Auth::user()->activated == 2)
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-list-thumb"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Produk</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('menu.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Menu PPOB</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('kategori.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Kategori Produk</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('prabayar.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Prabayar</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('pascabayar.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pascabayar</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('prefix.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Prefix Nomor</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-clock"></em>
                            </span>
                            <span class="nk-menu-text">Histori</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('mutation-history.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Mutasi Saldo</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('topup-history.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Top Up Saldo</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('koin.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Histori Koin</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('poin.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Histori Poin</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-wallet"></em>
                            </span>
                            <span class="nk-menu-text">Transaksi</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('trx.ppob.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Transaksi PPOB</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('inst.trf.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Instan Transfer</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('trf.saldo.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Transfer Saldo</span>
                                </a>
                            </li>
                            {{-- <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link">
                                    <span class="nk-menu-text">Transaksi Tiket</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{route('income.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-wallet-fill"></em>
                            </span>
                            <span class="nk-menu-text">Income Account</span>
                        </a>
                    </li>
                    {{-- <li class="nk-menu-item">
                        <a href="{{route('escrow.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-swap-alt-fill"></em>
                            </span>
                            <span class="nk-menu-text">Supplier Balance</span>
                        </a>
                    </li> --}}

                    @if (Auth::check() && Auth::user()->activated == 1 || Auth::user()->activated == 2)
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">general settings</h6>
                    </li>

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-briefcase"></em>
                            </span>
                            <span class="nk-menu-text">Utilitas</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ url('activity') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Log Aktifitas</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ url('v2/log-viewer') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Log System</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('push-command.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Push Command</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('tnc.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Syarat & Ketentuan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('policy.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Kebijakan Privasi</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('user.trash.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Trash</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-setting"></em>
                            </span>
                            <span class="nk-menu-text">Maintenance Module</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('api_key.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">API Key</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('banner.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Slide Banner</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('pay-method.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Metode Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('maintenance.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Maintenance Mode</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('set.poin.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Poin</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('set.koin.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Koin</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('set.produk.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Produk</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{route('set.biaya.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">Biaya Instan Trf</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('kontak.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Kontak</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
