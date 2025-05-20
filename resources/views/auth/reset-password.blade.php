<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đặt lại Mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e9f5ec;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.15);
        }
        .card-header {
            color: #198754; /* xanh lá */
            font-weight: 700;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1rem;
            user-select: none;
        }
        label {
            font-weight: 600;
            color: #198754;
        }
        .btn-primary {
            background-color: #198754;
            border: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            width: 100%;
            padding: 0.7rem;
            font-size: 1.1rem;
        }
        .btn-primary:hover {
            background-color: #145214;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 8px rgba(25, 135, 84, 0.5);
        }
        a.text-decoration-none {
            color: #198754;
        }
        a.text-decoration-none:hover {
            color: #145214;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Đặt lại Mật khẩu</h4>
                </div>
                <div class="card-body">

                    @if(session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.reset') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required
                            />
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                class="form-control"
                                required
                            />
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input
                                type="password"
                                name="new_password_confirmation"
                                id="new_password_confirmation"
                                class="form-control"
                                required
                            />
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cập nhật lại mật khẩu</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ url('login') }}" class="text-decoration-none">Quay lại trang đăng nhập</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
