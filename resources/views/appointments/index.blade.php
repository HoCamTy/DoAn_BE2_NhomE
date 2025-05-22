@extends('layouts.app')

@section('title', 'Quản Lý Lịch Hẹn')

@section('content')
    <div class="container">
        <div class="back-button mb-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Quản Lý Lịch Hẹn</h1>
            <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary">
                <i class="fa fa-plus-square"></i> Thêm lịch hẹn
            </a>
        </div>

        <!-- Filters Section -->
        <div class="mb-4">
            <div class="">
                <form method="GET" class="row g-3">
                    <!-- Date Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Ngày đặt lịch</label>
                        <input type="text" class="form-control flatpickr" name="date" value="{{ request('date') }}"
                            placeholder="Chọn ngày">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Chưa xác nhận
                            </option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                Đã xác nhận
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                Đã hoàn thành
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                Đã hủy
                            </option>
                        </select>
                    </div>

                    <!-- Service Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Dịch vụ</label>
                        <select class="form-select" name="service_id">
                            <option value="">Tất cả dịch vụ</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Staff Filter -->
                    <div class="col-md-3">
                        <label class="form-label">Nhân viên</label>
                        <select class="form-select" name="staff_id">
                            <option value="">Tất cả nhân viên</option>
                            @isset($staffs)
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}"
                                        {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Đặt lại
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>SĐT</th>
                        <th>Thời gian đặt</th>
                        <th>Tên dịch vụ</th>
                        <th>Trạng thái</th>
                        <th>Nhân viên</th>
                        <th>Tùy chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $index => $appointment)
                        <tr>
                            <td>{{ $appointments->firstItem() + $index }}</td>
                            <td>{{ $appointment->customer->customer_name }}</td>
                            <td>{{ $appointment->customer->phone }}</td>
                            <td>
                                {{ $appointment->appointment_date->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($appointment->services as $service)
                                        <li>{{ $service->service_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if ($appointment->status == 'pending')
                                    <span class="badge bg-warning">Chưa xác nhận</span>
                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-primary">Đã xác nhận</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-success">Đã hoàn thành</span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary">Không xác định</span>
                                @endif
                            </td>
                            <td>
                                {{ $appointment->staff->name ?? 'Chưa phân công' }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('appointments.edit', $appointment) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa lịch hẹn này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có lịch hẹn nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         <!-- Replace the existing pagination section -->
        <nav>
            <ul class="pagination justify-content-center">
                {{-- First Page Link --}}
                <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $appointments->url(1) }}" aria-label="First">
                        &laquo;
                    </a>
                </li>

                {{-- Previous Page Link --}}
                <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $appointments->previousPageUrl() }}" aria-label="Previous">
                        &lt;
                    </a>
                </li>

                {{-- Pagination Elements --}}
                @for ($i = 1; $i <= $appointments->lastPage(); $i++)
                    <li class="page-item {{ $appointments->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $appointments->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next Page Link --}}
                <li class="page-item {{ $appointments->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $appointments->nextPageUrl() }}" aria-label="Next">
                        &gt;
                    </a>
                </li>

                {{-- Last Page Link --}}
                <li class="page-item {{ $appointments->currentPage() == $appointments->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $appointments->url($appointments->lastPage()) }}" aria-label="Last">
                        &raquo;
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Items per page selector --}}
        <form method="GET" class="d-flex my-3 align-items-center" style="max-width: 120px;">
            <select name="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                @foreach ([10, 15] as $value)
                    <option value="{{ $value }}" {{ request('perPage') == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr", {
                dateFormat: "Y-m-d"
                // locale is set globally in layout
            });
        });
    </script>
@endpush
