<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'slug', 'status', 'created_date_int'
    ];
}
