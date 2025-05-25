<head>
    <title>Đặt Lịch Hẹn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .error-container {
            height: 0.5rem;
            position: relative;
            /* margin-top: 4px; */
        }

        .invalid-feedback {
            position: absolute;
        }




    </style>
</head>
@extends('layouts.master')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    @section('content')
        <main>
        <div class="container">
            <div class="back-button mb-3">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">&larr; Quay Lại</a>
            </div>

            <h1 class="mb-4">Đặt Lịch Hẹn</h1>
            <form action="{{ route('customer.appointments.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Cột 1: Thông tin cơ bản -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" value="{{ $customer->customer_name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" value="{{ $customer->phone }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">Ngày đặt lịch</label>
                            <input type="text"
                                class="form-control flatpickr-date @error('appointment_date') is-invalid @enderror"
                                id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}"
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
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $customer->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" value="{{ $customer->address }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">Thời gian</label>
                            <input type="text"
                                class="form-control flatpickr-time @error('appointment_time') is-invalid @enderror"
                                id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}"
                                placeholder="Chọn giờ">
                            <div class="error-container">
                                @error('appointment_time')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Full width: Dịch vụ và ghi chú -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="services" class="form-label">Chọn dịch vụ</label>
                            <select class="form-select @error('services') is-invalid @enderror" name="services[]"
                                multiple size="4">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
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
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            <div class="error-container">
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center pb-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i> Đặt lịch
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    @endsection

    {{-- <x-footer /> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
{{-- </body>

</html> --}}
