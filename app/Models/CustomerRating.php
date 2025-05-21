<?php

// app/Models/CustomerRating.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRating extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'service_rating', 'comments'];

    public $timestamps = false; 

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    protected $casts = [
    'created_at' => 'datetime',
    
];
}
