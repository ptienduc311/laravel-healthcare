<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_code', 'name', 'phone', 'birth', 'email', 'gender',
        'address', 'reason', 'created_date_int', 'status', 'province_id', 'district_id',
        'ward_id', 'appointment_id', 'specialty_id', 'doctor_id'
    ];
}
