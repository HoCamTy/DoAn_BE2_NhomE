<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentService extends Pivot
{
    // Khai báo bảng trung gian nếu tên khác quy ước Laravel
    protected $table = 'payment_service';

    // Cho phép fill pivot
    protected $fillable = ['payment_id', 'service_id', 'staff_id'];

    // Định nghĩa quan hệ với Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
