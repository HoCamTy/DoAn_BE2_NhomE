<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #00564e;
            color: white;
        }

        .btn-primary {
            background-color: #00564e;
            border-color: #00564e;
        }

        .btn-primary:hover {
            background-color: #004d46;
            border-color: #004d46;
        }

        .btn-outline-secondary {
            color: #00564e;
            border-color: #00564e;
        }

        .btn-outline-secondary:hover {
            background-color: #00564e;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Đăng Nhập</h4>
                    </div>
                    <div class="card-body">
                        @if (session('notification'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('notification') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{ old('username') }}" required>

                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        Hiển thị
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                            </div>
                            <div class="text-center mt-3">
                                <small>
                                    Bạn chưa có tài khoản?
                                    <a href="{{route('register')}}" class="text-decoration-none" style="color: #00564e;">Đăng ký ngay</a>
                                </small>
                                <br>
                                <small>
                                    Quên mật khẩu?
                                   <a href="{{ route('password.form') }}" class="text-decoration-none" style="color: #00564e;">Đặt lại mật khẩu</a>
                                </small>
                            </div>
                            @error('username')
                                <div class="alert {{ session('alertType', 'alert-danger') }} text-center mt-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const isPasswordHidden = passwordField.type === 'password';
            passwordField.type = isPasswordHidden ? 'text' : 'password';
            this.textContent = isPasswordHidden ? 'Ẩn' : 'Hiển thị';
        });
    </script>
</body>

</html>
