<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">
        <a href="{{route('index')}}" class="navbar-brand">
            <img src="{{ asset('images/logo-lani.png') }}" alt="Logo" style="width: 50px; height: 50px;">
        </a>
        <a class="navbar-brand" href="/">Trang chủ</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="">Dịch vụ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}">Đặt lịch</a></li>
                <li class="nav-item"><a class="nav-link" href="">Liên hệ</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                {{-- @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.createUser') }}">Đăng ký</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Đăng xuất</a></li>
                @endguest --}}
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
                        <form method="post" action="{{ route('logout') }}" class="d-inline">
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
</nav>
