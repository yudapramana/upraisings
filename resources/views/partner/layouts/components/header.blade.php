<header class="py-1">
    <div class="container">
        <!-- Start Header -->
        <div class="header">
            <nav class="navbar navbar-expand-md navbar-light px-0">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('/') }}nadist/assets/images/logo-icon.png" alt="logo">
                    <span>
                        {{-- <img src="{{ asset('/') }}nadist/assets/images/logo-text.png" alt="logo"> --}}
                        A N G K O T A P P
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        @if (!\Illuminate\Support\Facades\Auth::user())
                            <li class="nav-item pr-3">
                                <a href="/login" class="btn btn-custom btn-outline-info btn-lg">Login</a>
                            </li>
                        @else
                            <li>
                                <a class="btn btn-custom btn-outline-info btn-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
                            <a href="http://wrappixel.com/demos/admin-templates/nice-admin/landingpage/" class="btn btn-custom btn-info btn-lg" target="_blank">Check Pro Version</a>
                        </li> --}}
                    </ul>
                </div>

            </nav>
        </div>
        <!-- End Header -->
    </div>
</header>
