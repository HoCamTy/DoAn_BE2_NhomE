@extends('layouts.app')

@section('content')
    <!-- Nội Dung Chính -->
    <div class="row g-4">
        <!-- Dịch Vụ -->
        <div class="col-md-6">
            <a href="{{ route('services.index') }}" class="card-link">
                <div class="card shadow">
                    <img src="{{ asset('images/dichvu.jpg') }}" alt="Category">
                    <h5 class="card-title">Dịch Vụ</h5>
                </div>
            </a>
        </div>
        <!-- Nhân Viên -->
        <div class="col-md-6">
            <a href="" class="card-link">
                <div class="card shadow">
                    <img src="{{ asset('images/nhanvien.png') }}" alt="Staff">
                    <h5 class="card-title">Nhân Viên</h5>
                </div>
            </a>
        </div>
        <!-- Khách Hàng -->
        <div class="col-md-6">
            <a href="" class="card-link">
                <div class="card shadow">
                    <img src="{{ asset('images/khachhang.jpg') }}" alt="Customer">
                    <h5 class="card-title">Khách Hàng</h5>
                </div>
            </a>
        </div>
        <!-- Thanh Toán -->
        <div class="col-md-6">
            <a href="" class="card-link">
                <div class="card shadow">
                    <img src="{{ asset('images/thanhtoan2.jpg') }}" alt="Payment">
                    <h5 class="card-title">Thanh Toán</h5>
                </div>
            </a>
        </div>
        <!-- Đánh giá -->
        <div class="col-md-6">
            <a href="" class="card-link">
                <div class="card shadow custom-card">
                    <img src="{{ asset('images/dgia.jpg') }}" alt="danhgia" class="img-fluid">
                    <h5 class="card-title">Đánh giá</h5>
                </div>
            </a>
        </div>
        <!-- đặt lịch-->
        <div class="col-md-6">
            <a href="{{route('appointments.index')}}" class="card-link">
                <div class="card shadow custom-card">
                    <img src="{{ asset('images/dlich.jpg') }}" alt="datlich" class="img-fluid">
                    <h5 class="card-title">Đặt lịch</h5>
                </div>
            </a>
        </div>
    </div>
@endsection
