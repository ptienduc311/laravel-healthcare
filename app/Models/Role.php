<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'slug_role', 'description', 'created_date_int'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permissions')->withTimestamps();
    }
}
