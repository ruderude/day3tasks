<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follower extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "mid",
        "name",
        "icon_url",
        "blocked_at",
        "freeze_at",
    ];
}
