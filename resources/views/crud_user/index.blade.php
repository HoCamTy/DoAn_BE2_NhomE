<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .footer {
            background-color: #212529;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Trang chủ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="">Dịch vụ</a></li>
                <li class="nav-item"><a class="nav-link" href="">Đặt lịch</a></li>
                <li class="nav-item"><a class="nav-link" href="">Liên hệ</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.createUser') }}">Đăng ký</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('signout') }}">Đăng xuất</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


<!-- Hero -->
<div class="hero">
    <h1 class="display-4">Chào mừng bạn đến với Lani Spa</h1>
</div>


<!-- Người dùng -->
{{-- <div class="container my-5">
    <h2 class="mb-4">Danh sách người dùng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u['name'] }}</td>
                    <td>{{ $u['email'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

<!-- Danh sách danh mục -->
<div class="container my-5">
    <h2 class="mb-4">Danh mục dịch vụ</h2>
    <ul class="list-group">
        @foreach ($categories as $cat)
            <li class="list-group-item">
                <strong>{{ $cat->category_name }}</strong> – {{ $cat->description }}
            </li>
        @endforeach
    </ul>
</div>

<!-- Danh sách dịch vụ -->
<div class="container my-5">
    <h2 class="mb-4">Các dịch vụ</h2>
    <div class="row">
        @foreach ($services as $sv)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sv->service_name }}</h5>
                        <p class="card-text">
                            Giá: {{ number_format($sv->price, 0, ',', '.') }} VND<br>
                            Thời lượng: {{ $sv->service_duration }} phút
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        &copy;Lani spa - 53 Võ Văn Ngân - Linh Chiểu - Thủ Đức
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
