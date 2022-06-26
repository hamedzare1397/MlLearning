<?php

namespace Ml\Fuzzy\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'text',
        'level',
        'context',
    ];

}
