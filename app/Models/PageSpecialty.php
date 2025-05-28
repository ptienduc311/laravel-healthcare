<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PageSpecialty extends Model
{
    protected $fillable = [
        'description', 'image_id', 'content', 'medical_specialty_id', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }

    public function getThumbAttribute()
    {
        if ($this->image?->src) {
            return Storage::url($this->image->src);
        }

        return asset('assets/images/thumb-symbol.png');
    }
}
