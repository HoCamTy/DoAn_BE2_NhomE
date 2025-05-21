<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'payment_method',
    ];

    public function customer()
{
    return $this->belongsTo(Customer::class);
}

    public function services()
    {
        return $this->belongsToMany(Service::class, 'payment_service')
                    ->withPivot('staff_id')
                    ->withTimestamps();
    }
}
