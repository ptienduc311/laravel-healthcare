<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name', 'email', 'phone', 'birth', 'gender', 'province_id', 'district_id', 'ward_id', 'address', 'password', 'status',
        'google_id', 'remember_token', 'email_verified_at', 'reset_token', 'confirm_token', 'cancel_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'reset_token', 'confirm_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany{
        return $this->hasMany(Post::class);
    }

    public function medical_specialties(): HasMany{
        return $this->hasMany(MedicalSpecialty::class);
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function doctor() :HasOne
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }
 
    public function hasRole($slugRole)
    {
        return $this->roles->contains('slug_role', $slugRole);
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->where('slug', $permission)->count() > 0) {
                return true;
            }
        }
        return false;
    }
}
