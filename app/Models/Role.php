<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'created_date_int'];

    public function users(): BelongsToMany{
        return $this->belongsToMany(Role::class);
    }
}
