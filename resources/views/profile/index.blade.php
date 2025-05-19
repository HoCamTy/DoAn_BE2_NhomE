<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Điều hướng -->
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ url('/list') }}" class="btn btn-secondary">&larr; Danh sách người dùng</a>
            <a href="{{ route('signout') }}" class="btn btn-danger">Đăng xuất</a>
        </div>
        
        <h2 class="mb-4">Thông Tin Cá Nhân</h2>

        <!-- Thông báo -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Hiển thị lỗi -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Thẻ thông tin -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Thông tin hiện tại</h5>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Tên đăng nhập:</strong> {{ $user->username }}</p>
                <p class="card-text"><strong>Họ và tên:</strong> {{ $user->full_name }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="card-text"><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa có số điện thoại' }}</p>
            </div>
        </div>

        <!-- Form cập nhật -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Cập nhật thông tin</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $user->phone) }}" 
                               placeholder="Nhập số điện thoại">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>