<header class="navbar navbar-expand-lg navbar-dark" style="background-color: #00564e;">
    <div class="container-fluid">
        <a href="{{route('home')}}" class="navbar-brand">
            <img src="{{ asset('images/logo-lani.png') }}" alt="Logo" style="width: 100px; height: 100px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Auth::guard('web')->check() || Auth::guard('customer')->check())
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('profile') }}">
    <i class="fas fa-user"></i>
    @if (Auth::guard('customer')->check())
        {{ Auth::guard('customer')->user()->customer_name }}
    @else
        {{ Auth::guard('web')->user()->name }}
    @endif
</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link text-white border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</header>
