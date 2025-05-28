<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // ✅ Cho phép gán các trường sau:
    protected $fillable = [
        'customer_id',
        'total_amount',
        'payment_method',
    ];

    /**
     * Quan hệ: Thanh toán thuộc về một khách hàng
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Quan hệ: Thanh toán có nhiều dịch vụ (qua bảng trung gian payment_service)
     * Đồng thời kèm staff_id từ bảng pivot
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'payment_service')
                    ->withPivot('staff_id')
                    ->withTimestamps(); 
    }
}
