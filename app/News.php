<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'label', 'image_path', 'text', 'block',
    ];
    protected $table = 'news';
}
