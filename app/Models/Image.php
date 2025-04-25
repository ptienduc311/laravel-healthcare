<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    protected $fillable = [
        'name', 'src', 'size', 'type', 'created_by', 'created_date_int'
    ];

    public function post(): HasOne{
        return $this->hasOne(Post::class, 'image_id', 'id');
    }

    public function medical_specialty(): HasOne{
        return $this->hasOne(MedicalSpecialty::class, 'image_id', 'id');
    }

    public function page_specialty(): HasOne{
        return $this->hasOne(PageSpecialty::class, 'image_id', 'id');
    }
}
