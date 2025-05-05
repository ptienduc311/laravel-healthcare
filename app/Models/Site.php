<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['phone', 'hotline', 'email', 'address', 'link_facebook', 'link_zalo', 'link_youtube'];

}
