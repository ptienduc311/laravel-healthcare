<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    
    protected $fillable = [
        'name', 'slug', 'status', 'created_date_int'
    ];

    public function posts(): HasMany{
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
