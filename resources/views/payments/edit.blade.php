@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Chỉnh sửa Thanh Toán</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Chọn khách hàng -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Khách hàng:</label>
            <select id="customer_id" name="customer_id" class="form-select" required>
                <option value="">-- Chọn khách hàng --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ $payment->customer_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Chọn dịch vụ & nhân viên -->
        <div class="mb-3">
            <label class="form-label">Dịch vụ & Nhân viên phụ trách:</label>
            @foreach ($services as $service)
    @php
        // Tìm bản ghi pivot cho dịch vụ này
        $pivot = $payment->services->firstWhere('id', $service->id);
        // Nếu có pivot thì lấy staff_id, ngược lại null
        $staffId = $pivot
            ? ($pivot->pivot->staff_id ?? null)
            : null;
        // Đánh dấu checkbox đã check nếu dịch vụ được chọn trước đó
        $selected = (bool) $pivot;
    @endphp

    <div class="d-flex align-items-center mb-2">
        <div class="form-check me-3">
            <input
                class="form-check-input"
                type="checkbox"
                name="services[]"
                id="service_{{ $service->id }}"
                value="{{ $service->id }}"
                {{ $selected ? 'checked' : '' }}
            >
            <label class="form-check-label" for="service_{{ $service->id }}">
                {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
            </label>
        </div>

        <select name="staff[]" class="form-select w-auto">
            <option value="">-- Chọn nhân viên --</option>
            @foreach($staff as $s)
                <option value="{{ $s->id }}" {{ $s->id == $staffId ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
    </div>
@endforeach
        </div>

        <!-- Phương thức thanh toán -->
        <div class="mb-3">
            <label for="payment_method" class="form-label">Phương thức thanh toán:</label>
            <select id="payment_method" name="payment_method" class="form-select" required>
                <option value="cash"  {{ $payment->payment_method == 'cash'  ? 'selected' : '' }}>Tiền mặt</option>
                <option value="card"  {{ $payment->payment_method == 'card'  ? 'selected' : '' }}>Thẻ</option>
                <option value="bank"  {{ $payment->payment_method == 'bank'  ? 'selected' : '' }}>Chuyển khoản</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary ms-2">Hủy</a>
    </form>
</div>
@endsection
