<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

 
    protected $table = 'staffs';

    protected $fillable = ['staff_name', 'staff_phone', 'email'];
    public $timestamps = false;
}
