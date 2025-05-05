<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalSpecialty extends Model
{
    protected $fillable = [
        'name', 'slug', 'image_icon_id', 'image_id', 'description', 'status', 'created_by', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function image_icon(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_icon_id', 'id');
    }

    public function user(): BelongsTo{
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }
}
