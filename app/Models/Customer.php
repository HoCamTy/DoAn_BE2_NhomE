<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Authenticatable
{
    // Bảng trong CSDL
    protected $table = 'customers';

    // Các cột có thể gán giá trị
    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'create_date',
        'password',
    ];

    // Không sử dụng timestamps (created_at, updated_at)
    public $timestamps = false;

    // Ép kiểu dữ liệu cho trường
    protected $casts = [
        'create_date' => 'datetime',
    ];

    /**
     * Quan hệ: Một khách hàng có nhiều lịch hẹn
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Quan hệ: Một khách hàng thuộc về một người dùng (user)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ: Một khách hàng có nhiều thanh toán
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
