<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalSpecialty extends Model
{
    protected $fillable = [
        'name', 'slug', 'image_id', 'status', 'created_by', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function user(): BelongsTo{
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }
}
