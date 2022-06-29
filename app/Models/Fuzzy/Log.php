<?php

namespace App\Models\Fuzzy;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'text',
        'level',
        'context',
    ];

}
