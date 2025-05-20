<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationResult extends Model
{
    protected $fillable = [
        'book_id', 'diagnose', 'clinical_examination', 'conclude', 'treatment', 'medicine', 're_examination_date', 'created_date_int'
    ];
}
