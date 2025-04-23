<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSpecialty extends Model
{
    protected $fillable = [
        'description', 'image_id', 'content', 'medical_specialty_id', 'created_by', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }
}
