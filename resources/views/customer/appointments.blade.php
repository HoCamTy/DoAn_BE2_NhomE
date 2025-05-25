@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lịch hẹn của tôi</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ngày hẹn</th>
                        <th>Dịch vụ</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
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
                                @endif
                            </td>
                            <td>
                                @if ($appointment->status != 'completed' && $appointment->status != 'cancelled')
                                    <form action="{{ route('customer.appointments.cancel', $appointment) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn hủy lịch hẹn này?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Hủy lịch
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Bạn chưa có lịch hẹn nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('customer.dashboard') }}">Quay lại</a>
@endsection
