@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <a href="{{ route('index') }}" class="btn btn-secondary mb-3">&larr; Quay Lại</a>

    <h2>Thông Tin Khách Hàng</h2>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5>Xin chào</h5>
            <p class="card-text"><strong>Email:</strong> {{ $customer->email }}</p>
            <p class="card-text"><strong>Số điện thoại:</strong> {{ $customer->phone ?? 'Chưa có số điện thoại' }}</p>

           <form action="{{ route('profile.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Thay đổi email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Thay đổi số điện thoại</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
        @error('phone')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
</form>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-danger mt-3">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
