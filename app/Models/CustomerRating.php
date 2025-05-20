<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/CustomerRating.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRating extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'service_rating', 'comments'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
