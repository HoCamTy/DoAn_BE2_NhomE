@extends('layouts.app')

<style>
    .pagination .page-item.active .page-link {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: white !important;
    }

    .pagination .page-link {
        color: black;
        border: 1px solid #ddd;
    }

    .pagination ~ p {
        display: none;
    }
</style>

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Danh sách thanh toán</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('payments.create') }}" class="btn btn-success">+ Tạo thanh toán</a>

        <form method="GET" action="{{ route('payments.index') }}" class="d-flex" style="max-width: 300px;">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm thanh toán..." value="{{ request('search') }}">
            <button class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>Nhân viên</th>
                <th>Dịch vụ</th>
                <th>Tổng tiền (VND)</th>
                <th>Hình thức</th>
                <th>Ngày tạo</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                @php $count = $payment->services->count(); @endphp
                @foreach($payment->services as $index => $service)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ $count }}">
                                {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->parent->iteration }}
                            </td>
                            <td rowspan="{{ $count }}">
                                {{ $payment->customer->customer_name ?? '---' }}
                            </td>
                        @endif

                        <td>
                            {{ optional(\App\Models\Staff::find($service->pivot->staff_id))->staff_name ?? '---' }}
                        </td>

                        <td>{{ $service->service_name ?? '---' }}</td>

                        @if($index === 0)
                            <td rowspan="{{ $count }}">
                                {{ number_format($payment->total_amount, 0, ',', '.') }} VND
                            </td>
                            <td rowspan="{{ $count }}">{{ $payment->payment_method }}</td>
                            <td rowspan="{{ $count }}">{{ $payment->created_at->format('d/m/Y H:i:s') }}</td>
                            <td rowspan="{{ $count }}">
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">Không có thanh toán nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {!! $payments->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') !!}
    </div>
    <div class="text-center mt-3">
    <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary mt-4">← Quay lại trang chủ</a>
</div>

</div>
@endsection
