@extends('layouts.app')
@section('title', 'Quản Lý Danh Mục - Dịch Vụ')
@section('content')
    <div class="container">
        <div class="back-button">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">&larr; Quay Lại</a>
        </div>
        <div>
            <h1 class="d-flex justify-content-between align-items-center">
                Quản Lý Danh Mục - Dịch Vụ
                <a href="{{ route('services.create') }}" class="btn btn-outline-primary">
                    <i class="fa fa-plus-square"></i> Thêm dịch vụ
                </a>
            </h1>

            <form method="GET" class="d-flex align-items-center my-3" style="max-width: 400px; margin: 0 auto;">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm dịch vụ"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary">Tìm</button>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Danh mục</th>
                    <th>Tên dịch vụ</th>
                    <th>Giá</th>
                    <th>Tùy chỉnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $index => $service)
                    <tr>
                        <td>{{ $index + $services->firstItem() }}</td>
                        <td>
                            @foreach ($service->categories as $category)
                                <span class="badge text-bg-warning">{{ $category->category_name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $service->service_name }}</td>
                        <td>{{ number_format($service->price, 0) }}$</td>
                        <td>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-outline-primary">
                                <i class="far fa-edit"></i> Chỉnh sửa
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST"
                                class="d-inline-flex align-items-center"
                                onsubmit="return confirm('Bạn xác nhận xóa dịch vụ này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Replace the existing pagination section -->
        <nav>
            <ul class="pagination justify-content-center">
                {{-- First Page Link --}}
                <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $services->url(1) }}" aria-label="First">
                        &laquo;
                    </a>
                </li>

                {{-- Previous Page Link --}}
                <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $services->previousPageUrl() }}" aria-label="Previous">
                        &lt;
                    </a>
                </li>

                {{-- Pagination Elements --}}
                @for ($i = 1; $i <= $services->lastPage(); $i++)
                    <li class="page-item {{ $services->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $services->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next Page Link --}}
                <li class="page-item {{ $services->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $services->nextPageUrl() }}" aria-label="Next">
                        &gt;
                    </a>
                </li>

                {{-- Last Page Link --}}
                <li class="page-item {{ $services->currentPage() == $services->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $services->url($services->lastPage()) }}" aria-label="Last">
                        &raquo;
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Items per page selector --}}
        <form method="GET" class="d-flex my-3 align-items-center" style="max-width: 120px;">
            <select name="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                @foreach ([5, 10, 15] as $value)
                    <option value="{{ $value }}" {{ request('perPage') == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
@endsection
