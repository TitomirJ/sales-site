<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'label', 'image_path', 'text', 'block',
    ];
}
