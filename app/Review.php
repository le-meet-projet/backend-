<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function workshop()
    {
        return $this->belongsTo('App\User');
    }
}
