<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAppointments extends Model
{
    protected $fillable = [
        'doctor_id', 'day_examination', 'type', 'created_by', 'created_date_int'
    ];
}
