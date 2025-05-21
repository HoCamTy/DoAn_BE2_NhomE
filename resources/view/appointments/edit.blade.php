@extends('layouts.app')

@section('title', 'Chỉnh Sửa Lịch Hẹn')

@push('styles')
    <style>
        .error-container {
            height: 0.5rem;
            position: relative;
        }

        .invalid-feedback {
            position: absolute;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="back-button mb-3">
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>

        <h1 class="mb-4">Chỉnh Sửa Lịch Hẹn</h1>

        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Cột 1: Thông tin cơ bản -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                            id="customer_name" name="customer_name"
                            value="{{ old('customer_name', $appointment->customer->customer_name) }}">
                        <div class="error-container">
                            @error('customer_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $appointment->customer->phone) }}">
                        <div class="error-container">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Ngày đặt lịch</label>
                        <input type="text"
                            class="form-control flatpickr-date @error('appointment_date') is-invalid @enderror"
                            id="appointment_date" name="appointment_date"
                            value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                            placeholder="Chọn ngày">
                        <div class="error-container">
                            @error('appointment_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Cột 2: Thông tin bổ sung -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $appointment->customer->email) }}">
                        <div class="error-container">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $appointment->customer->address) }}">
                        <div class="error-container">
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Thời gian</label>
                        <input type="text"
                            class="form-control flatpickr-time @error('appointment_time') is-invalid @enderror"
                            id="appointment_time" name="appointment_time"
                            value="{{ old('appointment_time', $appointment->appointment_date->format('H:i')) }}"
                            placeholder="Chọn giờ">
                        <div class="error-container">
                            @error('appointment_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                                Chưa xác nhận
                            </option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>
                                Đã xác nhận
                            </option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                                Đã hoàn thành
                            </option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>
                                Đã hủy
                            </option>
                        </select>
                        <div class="error-container">
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Full width: Dịch vụ và ghi chú -->
                <div class="col-12">
                    <div class="mb-3">
                        <label for="services" class="form-label">Chọn dịch vụ</label>
                        <select class="form-select @error('services') is-invalid @enderror" name="services[]" multiple
                            size="4">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ in_array($service->id, old('services', $appointment->services->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error-container">
                            @error('services')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                        <div class="error-container">
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center pb-2">
                        <button type="submit" class="btn btn-primary">
                            Xác nhận
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                locale: "vn"
            });

            flatpickr(".flatpickr-time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                locale: "vn"
            });
        });
    </script>
@endpush
