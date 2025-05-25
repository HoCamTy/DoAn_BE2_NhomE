@include('layouts.home.header')

@include('layouts.home.menu')


{{-- <!-- Hero -->
<div class="hero">
    <h1 class="display-4">Chào mừng bạn đến với Lani Spa</h1>
</div> --}}


<!-- Người dùng -->
{{-- <div class="container my-5">
    <h2 class="mb-4">Danh sách người dùng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u['name'] }}</td>
                    <td>{{ $u['email'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

@yield('content')

<!-- Footer -->
<footer class="footer">
    <div class="container">
        &copy;Lani spa - 53 Võ Văn Ngân - Linh Chiểu - Thủ Đức
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
