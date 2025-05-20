<!-- resources/views/ratings/index.blade.php -->
@extends('layouts.app') <!-- hoặc layout bạn đang dùng -->

@section('content')
<div class="container">
    <div class="rating-container">
        <h2 class="text-center">Danh Sách Đánh Giá Dịch Vụ</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($ratings->count())
            @foreach ($ratings as $rating)
                <div class="rating-item">
                    <h5>{{ $rating->customer->name ?? 'Không rõ' }}
                        <span class="stars">
                            @for ($i = 0; $i < $rating->service_rating; $i++)
                                ★
                            @endfor
                        </span>
                    </h5>
                    <p class="comment">"{{ $rating->comments }}"</p>
                    <p><small>Đánh giá vào lúc: {{ $rating->created_at->format('d/m/Y H:i:s') }}</small></p>
                </div>
            @endforeach
        @else
            <p>Chưa có đánh giá nào.</p>
        @endif
    </div>
</div>
@endsection
