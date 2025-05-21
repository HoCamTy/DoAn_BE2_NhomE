@extends('layouts.app')

@section('content')
<style>
    .btn-green {
        background-color: #198754;
        color: white;
        border: none;
    }

    .btn-green:hover {
        background-color: #157347;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-5">
        <h4 class="text-center mb-4" style="color: #198754;">Đặt lại Mật khẩu</h4>
        <div class="card shadow rounded-4">
            <div class="card-body px-4 py-4">
                @if (session('message'))
                    <div class="alert alert-info text-center">{{ session('message') }}</div>
                @endif

                <form method="POST" action="{{ route('password.reset') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" id="new_password" class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-pill" required>
                    </div>

                    <button type="submit" class="btn btn-green w-100 rounded-pill mt-2">Cập nhật mật khẩu</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: #198754;">← Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
