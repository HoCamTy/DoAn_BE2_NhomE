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
</style>
<style>
    .pagination ~ p {
        display: none;
    }
</style>

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách thanh toán</h2>

    <a href="{{ route('payments.create') }}" class="btn btn-success mb-3">+ Tạo thanh toán</a>

    <form method="GET" action="{{ route('payments.index') }}" class="d-flex mb-4">
        <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm thanh toán..." value="{{ request('search') }}">
        <button class="btn btn-primary">Tìm kiếm</button>
    </form>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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
            @php $cnt = $payment->services->count(); @endphp
            @foreach($payment->services as $i => $service)
                <tr>
                    @if($i === 0)
                        <td rowspan="{{ $cnt }}">{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->parent->iteration }}</td>
                        <td rowspan="{{ $cnt }}">{{ $payment->customer->name ?? '---' }}</td>
                    @endif

                    <td>{{ \App\Models\Staff::find($service->pivot->staff_id)->name ?? '---' }}</td>
                    <td>{{ $service->name }}</td>

                    @if($i === 0)
                        <td rowspan="{{ $cnt }}">{{ number_format($payment->total_amount, 0, ',', '.') }} VND</td>
                        <td rowspan="{{ $cnt }}">{{ $payment->payment_method }}</td>
                        <td rowspan="{{ $cnt }}">{{ $payment->created_at->format('d/m/Y H:i:s') }}</td>
                        <td rowspan="{{ $cnt }}">
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        @empty
            <tr><td colspan="8">Không có thanh toán nào.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
    {!! $payments->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') !!}
</div>
</div>


@endsection
