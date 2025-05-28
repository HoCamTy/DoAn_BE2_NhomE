<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'service_name',
        'price',
        'service_duration',
        'create_date'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'create_date' => 'datetime'
    ];

    /**
     * Quan hệ: Dịch vụ thuộc nhiều danh mục
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_service');
    }

    /**
     * Quan hệ: Dịch vụ thuộc nhiều cuộc hẹn
     */
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class)
                    ->withTimestamps();
    }

    /**
     * Quan hệ: Dịch vụ được sử dụng trong nhiều thanh toán
     */
    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'payment_service')
                    ->withPivot('staff_id')
                    ->withTimestamps();
    }

    /**
     * Quan hệ: Lấy các nhân viên thực hiện dịch vụ (thông qua bảng payment_service)
     */
  public function staff()
{
    return $this->belongsToMany(Staff::class, 'payment_service', 'service_id', 'staff_id');
}
}
