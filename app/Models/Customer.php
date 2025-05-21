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
public $timestamps = false;
    protected $casts = [
        'create_date' => 'datetime'
    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
