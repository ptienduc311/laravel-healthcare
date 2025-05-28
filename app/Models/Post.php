<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'status', 'is_outstanding', 'category_id', 'image_id', 'created_date_int'
    ];

    public function category(): BelongsTo{
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }
}
