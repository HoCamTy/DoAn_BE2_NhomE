@extends('layouts.app') {{-- Nếu bạn có layout, nếu không thì bỏ dòng này --}}

@section('content')
<div class="container mt-5">
    <h2>Thông Tin Cá Nhân</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Xin chào, {{ $user->name }}!</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa có số điện thoại' }}</p>

            <form method="POST" action="{{ url('/profile') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Thay đổi email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Thay đổi số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>

            <a href="{{ route('logout') }}" class="btn btn-danger mt-3"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
