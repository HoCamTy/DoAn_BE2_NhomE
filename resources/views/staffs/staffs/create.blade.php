@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thêm nhân viên mới</h2>
    <form method="POST" action="{{ route('staffs.store') }}">
        @csrf
        <div class="mb-3">
            <label>Tên nhân viên</label>
            <input type="text" name="staff_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="staff_phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('staffs.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
