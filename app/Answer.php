<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id','value'];
    function user() {
        return $this->belongsTo('App\User');
    }
}
