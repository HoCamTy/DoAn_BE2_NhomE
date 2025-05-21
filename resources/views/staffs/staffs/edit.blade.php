@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa nhân viên</h2>
    <form method="POST" action="{{ route('staffs.update', $staff->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Tên nhân viên</label>
            <input type="text" name="staff_name" class="form-control" value="{{ $staff->staff_name }}" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="staff_phone" class="form-control" value="{{ $staff->staff_phone }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $staff->email }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('staffs.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
