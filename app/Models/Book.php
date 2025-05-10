<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'book_code', 'name', 'phone', 'birth', 'email', 'gender', 'date_examination',
        'address', 'reason', 'created_date_int', 'status', 'province_id', 'district_id',
        'ward_id', 'appointment_id', 'specialty_id', 'doctor_id'
    ];

    public function province() :BelongsTo
    {
        return $this->belongsTo(Provinces::class, 'province_id', 'id');
    }

    public function district() :BelongsTo
    {
        return $this->belongsTo(Districts::class, 'district_id', 'id');
    }

    public function ward() :BelongsTo
    {
        return $this->belongsTo(Wards::class, 'ward_id', 'id');
    }

    public function doctor() :BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function specialty() :BelongsTo
    {
        return $this->belongsTo(MedicalSpecialty::class, 'specialty_id', 'id');
    }

    public function appointment() :BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
