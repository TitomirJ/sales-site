<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'users_jobs', 'user_id', 'job_id');
    }
}
