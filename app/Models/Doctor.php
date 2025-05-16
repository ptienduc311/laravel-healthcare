<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'slug_name', 'user_id', 'image_id', 'gender', 'address', 'email', 'phone', 'current_workplace', 'specialty_id', 'experience', 'academic_title', 'degree', 'regency', 'introduce', 'status', 'is_outstanding', 'created_by', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }

    public function user(): BelongsTo{
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }

    public function account() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    //Accessor
    public function getAvatarUrlAttribute()
    {
        if ($this->image?->src) {
            return Storage::url($this->image->src);
        }

        return asset($this->gender == 1 
            ? 'assets/images/male-doctor.jpg' 
            : 'assets/images/female-doctor.jpg');
    }
}
