@extends('layouts.master')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-6">
                <a href="{{ route('customer.appointments.create') }}" class="card-link">
                    <div class="card shadow">
                        <img src="{{ asset('images/dlich2.jpg') }}" alt="Appointment">
                        <h5 class="card-title">Đặt lịch hẹn mới</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('customer.appointments') }}" class="card-link">
                    <div class="card shadow">
                        <img src="{{ asset('images/dlich.jpg') }}" alt="Appointment">
                        <h5 class="card-title">Lịch hẹn của tôi</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
