<?php

return [
    'required' => 'Trường :attribute là bắt buộc.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'max' => [
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
    ],
    'min' => [
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
     ],
    'date' => 'Trường :attribute không phải là định dạng của ngày.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
    'date_format' => 'Trường :attribute không giống với định dạng :format.',
    'array' => 'Trường :attribute phải là một mảng.',
    'exists' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'regex' => [
        'phone' => 'Số điện thoại không hợp lệ',
    ],
    'unique' => [
        'phone' => 'Số điện thoại này đã được đăng ký.',
        'email' => 'Email này đã được đăng ký.',
    ],
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'attributes' => [
        'customer_name' => 'tên khách hàng',
        'phone' => 'số điện thoại',
        'email' => 'email',
        'address' => 'địa chỉ',
        'appointment_date' => 'ngày đặt lịch',
        'appointment_time' => 'thời gian',
        'services' => 'dịch vụ',
        'notes' => 'ghi chú',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu'
    ]
];
