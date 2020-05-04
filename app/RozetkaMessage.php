<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RozetkaMessage extends Model
{
    protected $fillable = [
        'chart_id','m_chart_id','body','m_receiver_id','sender','m_created_at'
    ];
}
