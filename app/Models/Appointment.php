<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id', 'hour_examination', 'day_examination', 'is_appointment', 'created_by', 'created_date_int'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function user(): BelongsTo{
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }
}