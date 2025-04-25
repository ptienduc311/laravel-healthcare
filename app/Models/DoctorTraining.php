<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTraining extends Model
{
    protected $fillable = [
        'time_training', 'content_training', 'doctor_id', 'created_date_int'
    ];
}
