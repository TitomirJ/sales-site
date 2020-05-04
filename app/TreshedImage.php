<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreshedImage extends Model
{
    protected $fillable = [
        'image_path', 'user_id', 
    ];
}
