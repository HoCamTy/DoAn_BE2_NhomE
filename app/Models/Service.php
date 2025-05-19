<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_service');
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class)
            ->withTimestamps();
    }
}
