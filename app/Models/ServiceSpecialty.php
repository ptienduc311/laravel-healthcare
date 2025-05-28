<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSpecialty extends Model
{
    protected $fillable = [
        'name', 'description', 'medical_specialty_id', 'created_date_int'
    ];
}
