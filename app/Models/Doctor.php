<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'slug_name', 'image_id', 'specialty_id', 'experience', 'academic_title', 'degree', 'regency', 'introduce', 'status', 'created_by', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }

    public function specialty(): BelongsTo{
        return $this->belongsTo(MedicalSpecialty::class, 'specialty_id', 'id');
    }

    public function doctor_prizes(): HasMany{
        return $this->hasMany(DoctorPrize::class, 'doctor_id', 'id');
    }

    public function doctor_training(): HasMany{
        return $this->hasMany(DoctorTraining::class, 'doctor_id', 'id');
    }

    public function doctor_works(): HasMany{
        return $this->hasMany(DoctorWork::class, 'doctor_id', 'id');
    }
}
