@extends('layouts.app')

@section('title', 'Trang thanh toán')

@section('content')
<h4 class="text-center text-uppercase fw-bold mb-4">Trang thanh toán</h4>

<!-- Nút quay lại -->
<div class="d-flex justify-content-start mb-3">
    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
        ← Quay lại danh sách thanh toán
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <!-- Khách hàng -->
            <div class="mb-3">
                <label for="customer_id" class="form-label"><strong>Khách hàng</strong></label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                    <option value="">Chọn khách hàng</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->customer_name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Dịch vụ -->
            <div class="mb-3" id="services-group">
                <label for="services" class="form-label"><strong>Dịch vụ</strong></label>
                <select name="services[]" id="services" class="form-select" multiple required size="5">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                            {{ $service->service_name }} - {{ number_format($service->price, 2) }} $
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Nhấn Ctrl + Click để chọn nhiều dịch vụ</small>
                @error('services')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nhân viên (chỉ chọn 1) -->
            <div class="mb-3">
                <label for="staff_id" class="form-label"><strong>Nhân viên</strong></label>
                <select name="staff_id" id="staff_id" class="form-select" required>
                    <option value="">Chọn nhân viên</option>
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                            {{ $staff->staff_name }}
                        </option>
                    @endforeach
                </select>
                @error('staff_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tổng tiền -->
            <div class="mb-3">
                <label for="total" class="form-label"><strong>Tổng tiền</strong></label>
                <input type="text" id="total_display" class="form-control" readonly value="{{ old('total') ?? '0.00 $' }}">
                <input type="hidden" name="total" id="total" value="{{ old('total') ?? '0.00' }}">
                @error('total')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Hình thức thanh toán -->
            <div class="mb-3">
                <label for="payment_method" class="form-label"><strong>Hình thức thanh toán</strong></label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Thẻ</option>
                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Chuyển khoản</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nút thanh toán -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Thanh toán</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('services');
        const totalInput = document.getElementById('total');
        const totalDisplay = document.getElementById('total_display');

        function calculateTotal() {
            let total = 0;
            Array.from(serviceSelect.selectedOptions).forEach(option => {
                const price = parseFloat(option.dataset.price || 0);
                if (!isNaN(price)) total += price;
            });
            total = total.toFixed(2);
            totalInput.value = total;
            totalDisplay.value = total + ' $';
        }

        // Tính lại khi thay đổi lựa chọn dịch vụ
        serviceSelect.addEventListener('change', calculateTotal);

        // Nếu reload có sẵn dữ liệu
        calculateTotal();
    });
</script>
@endpush
