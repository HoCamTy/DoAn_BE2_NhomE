<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin khách hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            color: #007BFF;
            text-decoration: none;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        .error-box {
            color: #721c24;
            background-color: #f8d7da;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: gray;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('customers.index') }}" class="back-btn">&larr; Quay lại danh sách</a>

        <h2>Chỉnh sửa thông tin khách hàng</h2>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="error-box">
                    <strong>Vui lòng kiểm tra lại:</strong>
                    <ul style="margin-top: 10px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

          <label for="customer_name">Tên khách hàng</label>
<input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $customer->customer_name) }}" required>


            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" id="phone"
                   value="{{ old('phone', $customer->phone) }}">

            <label for="email">Thông tin Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $customer->email) }}">

            <label for="address">Địa chỉ</label>
            <input type="text" name="address" id="address"
                   value="{{ old('address', $customer->address) }}">

            <button type="submit">Cập nhật</button>
        </form>
    </div>
</body>
</html>
