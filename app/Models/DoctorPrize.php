<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPrize extends Model
{
    protected $fillable = [
        'content_prize', 'doctor_id', 'created_date_int'
    ];
}
