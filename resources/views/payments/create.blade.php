@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trang thanh toán</h2>

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        {{-- Chọn khách hàng --}}
        <div class="mb-3">
            <label for="customer_id">Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                <option value="">Chọn khách hàng</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Dịch vụ --}}
        <div class="mb-3">
            <label for="services">Dịch vụ</label>
            <select name="services[]" id="services" class="form-select" multiple required>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                        {{ $service->name }} {{ number_format($service->price, 0, ',', '.') }} đ
                    </option>
                @endforeach
            </select>
            <small>Nhấn Ctrl + Click để chọn nhiều dịch vụ</small>
        </div>

        {{-- Nhân viên --}}
        <div class="mb-3">
            <label for="staffs">Nhân viên</label>
            <select name="staffs[]" class="form-select" multiple required>
                @foreach ($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
            <small>Nhấn Ctrl + Click để chọn nhiều nhân viên</small>
        </div>

        {{-- Tổng tiền (hiển thị) --}}
        <div class="mb-3">
            <label for="total_display">Tổng tiền</label>
            <input type="text" id="total_display" class="form-control" readonly>
            <input type="hidden" name="total" id="total"> {{-- Đây là giá trị gửi về server --}}
        </div>

        {{-- Hình thức thanh toán --}}
        <div class="mb-3">
            <label for="payment_method">Hình thức thanh toán</label>
            <select name="payment_method" class="form-select" required>
                <option value="cash">Tiền mặt</option>
                <option value="card">Thẻ</option>
                <option value="bank">Chuyển khoản</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
</div>

{{-- Script tính tổng tiền --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const servicesSelect = document.getElementById('services');
        const totalDisplay = document.getElementById('total_display');
        const totalHidden = document.getElementById('total');

        function calculateTotal() {
            let total = 0;
            Array.from(servicesSelect.selectedOptions).forEach(option => {
                const price = parseFloat(option.getAttribute('data-price')) || 0;
                total += price;
            });
            totalHidden.value = total;
            totalDisplay.value = total.toLocaleString('vi-VN');
        }

        servicesSelect.addEventListener('change', calculateTotal);
    });
</script>
@endsection
