<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    public function follower()
    {
        return $this->belongsTo('App\Models\Follower', 'mid', 'mid');
    }
}
