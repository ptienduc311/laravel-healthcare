<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorWork extends Model
{
    protected $fillable = [
        'time_work', 'content_work', 'doctor_id', 'created_date_int'
    ];
}
