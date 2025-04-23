<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'status', 'created_by', 'category_id', 'image_id', 'created_date_int'
    ];

    public function category(): BelongsTo{
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    public function image(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_id', 'id');
    }

    public function user(): BelongsTo{
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }
}
