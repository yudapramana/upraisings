<a href="index3.html" class="brand-link">
    <img src="{{ asset('/') }}dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">DASHBOARD</li>
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link @if (Request::segment(2) == '') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            @if (Auth::user()->role == 'admin')
                <li class="nav-header">VERIFICATION</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/angkot/verification') }}" class="nav-link @if (Request::segment(2) == 'angkot' && Request::segment(3) == 'verification') active @endif">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Pendaftaran Angkot</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/wallet/topup/verification') }}" class="nav-link @if (Request::segment(3) == 'topup' && Request::segment(4) == 'verification') active @endif">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Tambah Dana</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/wallet/withdraw/verification') }}" class="nav-link @if (Request::segment(3) == 'withdraw' && Request::segment(4) == 'verification') active @endif">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Tarik Dana</p>
                    </a>
                </li>
            @endif

            <li class="nav-header">MONITORING</li>

            <li class="nav-item">
                <a href="{{ url('/admin/angkot/') }}" class="nav-link @if (Request::segment(2) == 'angkot' && Request::segment(3) == '') active @endif">
                    <i class="nav-icon fas fa-bus"></i>
                    <p>Daftar Angkot</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/users') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Pengguna</p>
                </a>
            </li>

            <li class="nav-header">REPORTS</li>
            <li class="nav-item">
                <a href="{{ url('/admin/transactions') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Transaksi</p>
                </a>
            </li>


            {{-- <li class="nav-item @if (Request::segment(2) == 'angkot') menu-open @endif">
                <a href="#" class="nav-link @if (Request::segment(2) == 'angkot') active @endif">
                    <i class="nav-icon fas fa-bus"></i>
                    <p>
                        Manajemen Angkot
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/admin/angkot') }}" class="nav-link @if (Request::segment(2) == 'angkot' && Request::segment(3) == '') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Angkot</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/angkot/verification') }}" class="nav-link @if (Request::segment(3) == 'verification') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Verifikasi Angkot</p>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item @if (Request::segment(2) == 'wallet') menu-open @endif">
                <a href="#" class="nav-link @if (Request::segment(2) == 'wallet') active @endif">
                    <i class="nav-icon fas fa-bus"></i>
                    <p>
                        Manajemen Dana
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/admin/wallet/topup/verification') }}" class="nav-link @if (Request::segment(3) == 'topup' && Request::segment(4) == 'verification') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Topup</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/admin/wallet/withdraw/verification') }}" class="nav-link @if (Request::segment(3) == 'withdraw' && Request::segment(4) == 'verification') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Withdraw</p>
                        </a>
                    </li>
                </ul>
            </li> --}}


            {{-- <li class="nav-item">
                @if (Auth::user()->role == 'admin')
                    <a href={{ url('/admin/angkot') }} class="nav-link @if (Request::segment(2) == 'angkot') active @endif ">
                    @else
                        <a href={{ url('/admin/angkot') }} class="nav-link @if (Request::segment(2) == 'angkot') active @endif">
                @endif
                <i class="fas fa-table nav-icon"></i>
                <p>Kelola Angkot</p>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                @if (Auth::user()->role == 'admin')
                    <a href={{ url('/admin/angkot/verification') }} class="nav-link @if (Request::segment(2) == 'angkot/verification') active @endif ">
                    @else
                        <a href={{ url('/approval/angkot/verification') }} class="nav-link @if (Request::segment(2) == 'angkot/verification') active @endif">
                @endif
                <i class="fas fa-table nav-icon"></i>
                <p>Verifikasi Angkot</p>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                @if (Auth::user()->role == 'admin')
                    <a href={{ url('/admin/topup-verification') }} class="nav-link @if (Request::segment(2) == 'topup-verification') active @endif ">
                    @else
                        <a href={{ url('/approval/topup-verification') }} class="nav-link @if (Request::segment(2) == 'topup-verification') active @endif">
                @endif
                <i class="fas fa-table nav-icon"></i>
                <p>Verifikasi TopUp</p>
                </a>
            </li> --}}
            @if (Auth::user()->role == 'admin')
                {{-- <li class="nav-item">
                    <a href={{ url('/admin/vehicle') }} class="nav-link">
                        <i class="fas fa-car nav-icon"></i>
                        <p>List Kendaraan</p>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href={{ url('/admin/users') }} class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        <p>Pengguna</p>
                    </a>
                </li> --}}
            @else
            @endif
            {{-- <li class="nav-item">
                @if (Auth::user()->role == 'admin')
                    <a href={{ url('/admin/history') }} class="nav-link">
                    @else
                        <a href={{ url('/approval/history') }} class="nav-link">
                @endif
                <i class="fas fa-history nav-icon"></i>
                <p>Riwayat Kegiatan</p>
                </a>
            </li> --}}
        </ul>
    </nav>
</div>
