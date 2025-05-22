@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <a href="{{ route('customer.appointments.create') }}" class="card-link">
                    <div class="card shadow">
                        <img src="{{ asset('images/dlich2.jpg') }}" alt="Appointment">
                        <h5 class="card-title">Đặt Lịch Hẹn Mới</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('customer.appointments') }}" class="card-link">
                    <div class="card shadow">
                        <img src="{{ asset('images/dlich.jpg') }}" alt="Appointment">
                        <h5 class="card-title">Lịch Hẹn Của Tôi</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
