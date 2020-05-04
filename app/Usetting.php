<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usetting extends Model
{
    protected $fillable = [
        'user_id', 'n_par_1', 'n_par_2', 'n_par_3', 'n_par_4', 'n_par_3', 's_par_1', 's_par_2', 's_par_3', 's_par_4', 's_par_5'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
