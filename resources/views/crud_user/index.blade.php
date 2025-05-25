@extends('layouts.master')

@section('content')
<!-- Hero -->
<div class="hero">
    <h1 class="display-4">Chào mừng bạn đến với Lani Spa</h1>
</div>
<!-- Danh sách danh mục -->
<div class="container my-5">
    <h2 class="mb-4">Danh mục dịch vụ</h2>
    <ul class="list-group">
        @foreach ($categories as $cat)
            <li class="list-group-item">
                <strong>{{ $cat->category_name }}</strong> – {{ $cat->description }}
            </li>
        @endforeach
    </ul>
</div>

<!-- Danh sách dịch vụ -->
<div class="container my-5">
    <h2 class="mb-4">Các dịch vụ</h2>
    <div class="row">
        @foreach ($services as $sv)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sv->service_name }}</h5>
                        <p class="card-text">
                            Giá: {{ number_format($sv->price, 0, ',', '.') }} VND<br>
                            Thời lượng: {{ $sv->service_duration }} phút
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
