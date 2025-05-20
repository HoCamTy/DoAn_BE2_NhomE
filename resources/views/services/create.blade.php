@extends('layouts.app')
@section('title', 'Quản Lý Danh Mục - Dịch Vụ')
@section('content')
    <div class="container">
        <div class="back-button">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>

        <h1 class="">Thêm Dịch Vụ</h1>
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="service_name" class="form-label">Tên dịch vụ</label>
                <input type="text" class="form-control @error('service_name') is-invalid @enderror" id="service_name"
                    name="service_name" value="{{ old('service_name') }}">
                @error('service_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="service_duration" class="form-label">Thời gian dịch vụ</label>
                <input type="number" class="form-control @error('service_duration') is-invalid @enderror"
                    id="service_duration" name="service_duration" value="{{ old('service_duration') }}">
                @error('service_duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Danh mục</label>
                <select class="form-select @error('categories') is-invalid @enderror" name="categories[]"
                    aria-label="Select categories">
                    <option value="" disabled selected>Chọn danh mục</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('categories')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
@endsection
