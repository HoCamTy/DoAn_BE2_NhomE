<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'password',
        'create_date'
    ];

    protected $casts = [
        'create_date' => 'datetime'
    ];
    protected $table = 'customerrs'; 
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
