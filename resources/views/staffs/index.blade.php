@extends('layouts.app')

@section('content')
<style>
    .pagination {
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border-radius: 30px;
        padding: 8px 16px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
        transition: 0.3s;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        font-weight: bold;
    }

    .pagination .page-item .page-link:hover {
        background-color: #0056b3;
        color: #fff;
        border-color: #0056b3;
    }
</style>

<div class="container">
    <h2 class="mb-4">Danh sách nhân viên</h2>

    <form action="{{ route('staffs.index') }}" method="GET" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo tên, điện thoại, email...">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('staffs.create') }}" class="btn btn-success">+ Thêm nhân viên</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staffs as $staff)
            <tr>
                <td>{{ $staff->staff_name }}</td>
                <td>{{ $staff->staff_phone }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->create_date }}</td>
                <td>
                    <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Không tìm thấy nhân viên phù hợp.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Hiển thị liên kết phân trang -->
    <div class="d-flex justify-content-center">
        {{ $staffs->links() }}
    </div>
    <a href="{{ route('admin.dashboard') }}">Quay lại trang trước</a>
</div>
@endsection
