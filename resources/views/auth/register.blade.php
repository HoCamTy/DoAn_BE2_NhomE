@extends('layouts.basic')
@section('content')
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

        .invalid-feedback {
            display: block !important;
        }
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Đăng Ký</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Tên đăng nhập</label>
                                <input type="text" name="customer_name" id="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}"
                                    required>
                                @error('customer_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    required>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        Hiển thị
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                            </div>

                            <div class="text-center mt-3">
                                <small>
                                    Quay lại trang
                                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: #00564e;">
                                        Đăng Nhập
                                    </a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide password
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');

            togglePassword.addEventListener('click', function() {
                // Toggle password field
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle confirmation field
                passwordConfirm.setAttribute('type', type);

                // Toggle button text
                this.textContent = type === 'password' ? 'Hiển thị' : 'Ẩn';
            });
        });
    </script>
@endpush
