@extends('layouts.app')

@section('title', 'Chỉnh sửa thanh toán')

@section('content')
<div class="mb-3">
    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">&larr; Quay lại danh sách thanh toán</a>
</div>

<div class="card">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Chỉnh sửa thanh toán</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Khách hàng -->
            <div class="mb-3">
                <label for="customer_id" class="form-label"><strong>Khách hàng</strong></label>
                <select id="customer_id" name="customer_id" class="form-select" required>
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ $payment->customer_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Dịch vụ & Nhân viên -->
            <div class="mb-3">
                <label class="form-label"><strong>Dịch vụ & Nhân viên phụ trách</strong></label>
                <div class="border rounded p-2">
                    @foreach($services as $service)
                        @php
                            $pivot   = $payment->services->firstWhere('id', $service->id);
                            $checked = $pivot ? 'checked' : '';
                            $staffId = $pivot->pivot->staff_id ?? '';
                        @endphp

                        <div class="row align-items-center mb-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input
                                        class="form-check-input service-checkbox"
                                        type="checkbox"
                                        name="services[]"
                                        id="service_{{ $service->id }}"
                                        value="{{ $service->id }}"
                                        data-price="{{ $service->price }}"
                                        {{ $checked }}
                                    >
                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select
                                    name="staffs[]"
                                    class="form-select staff-select"
                                    data-service-id="{{ $service->id }}"
                                    {{ $checked ? '' : 'disabled' }}
                                >
                                    <option value="">-- Chọn nhân viên --</option>
                                    @foreach($staff as $s)
                                        <option value="{{ $s->id }}" {{ $s->id == $staffId ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Chỉ những dịch vụ được chọn mới có nhân viên tương ứng.</small>
                @error('services')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phương thức thanh toán -->
            <div class="mb-3">
                <label for="payment_method" class="form-label"><strong>Hình thức thanh toán</strong></label>
                <select id="payment_method" name="payment_method" class="form-select" required>
                    <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                    <option value="card" {{ $payment->payment_method == 'card' ? 'selected' : '' }}>Thẻ</option>
                    <option value="bank" {{ $payment->payment_method == 'bank' ? 'selected' : '' }}>Chuyển khoản</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tổng tiền -->
            <div class="mb-3">
                <label class="form-label"><strong>Tổng tiền</strong></label>
                <input type="text" name="total" id="total" class="form-control" value="{{ number_format($payment->total_amount, 2) }} đ" readonly>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Bật/tắt ô nhân viên theo dịch vụ được chọn
    document.querySelectorAll('.service-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const serviceId = this.value;
            const staffSelect = document.querySelector(`select[data-service-id="${serviceId}"]`);
            if (this.checked) {
                staffSelect.disabled = false;
            } else {
                staffSelect.disabled = true;
                staffSelect.value = '';
            }
            calculateTotal();
        });
    });

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.service-checkbox:checked').forEach(function (checkbox) {
            total += parseFloat(checkbox.dataset.price);
        });
        const totalField = document.getElementById('total');
        totalField.value = total.toFixed(2) + ' đ';
    }

    window.addEventListener('load', calculateTotal);
</script>
@endpush
