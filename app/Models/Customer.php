<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'create_date' 
    ];
public $timestamps = false;
    protected $casts = [
        'create_date' => 'datetime'
    ];
    public function appointments(): HasMany

    {
        return $this->hasMany(Appointment::class);
    }
    protected $table = 'customers'; 
}