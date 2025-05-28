<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class MedicalSpecialty extends Model
{
    protected $fillable = [
        'name', 'slug', 'image_icon_id', 'image_id', 'description', 'status', 'created_date_int'
    ];

    public function image(): BelongsTo{
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function image_icon(): BelongsTo{
        return $this->BelongsTo(Image::class, 'image_icon_id', 'id');
    }

    public function serviceSpecialties() :HasMany
    {
        return $this->hasMany(ServiceSpecialty::class);
    }

    public function pageSpecialty() :HasOne
    {
        return $this->hasOne(PageSpecialty::class);
    }

    public function getThumbAttribute()
    {
        if ($this->image?->src) {
            return Storage::url($this->image->src);
        }

        return asset('assets/images/thumb-symbol.png');
    }

    public function getIconAttribute()
    {
        if ($this->image_icon?->src) {
            return Storage::url($this->image_icon->src);
        }

        return asset('assets/images/medical-symbol.png');
    }
}
