@extends('layouts.app')
@section('title', 'Quản Lý Danh Mục - Dịch Vụ')
@section('content')
    <div class="container">
        <div class="back-button">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>

        <h1>Chỉnh Sửa Dịch Vụ</h1>

        <form action="{{ route('services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="service_name" class="form-label">Tên dịch vụ</label>
                <input type="text" class="form-control @error('service_name') is-invalid @enderror" id="service_name"
                    name="service_name" value="{{ old('service_name', $service->service_name) }}">
                @error('service_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" value="{{ old('price', $service->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="service_duration" class="form-label">Thời gian dịch vụ</label>
                <input type="number" class="form-control @error('service_duration') is-invalid @enderror"
                    id="service_duration" name="service_duration"
                    value="{{ old('service_duration', $service->service_duration) }}">
                @error('service_duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Danh mục</label>
                <select class="form-select @error('categories') is-invalid @enderror" name="categories[]"
                    aria-label="Select categories">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', $service->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('categories')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
@endsection
