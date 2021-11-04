<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Support\Line;
use App\Models\Follower;
use App\Models\Message;
use App\Models\Task;

class FollowerController extends Controller
{

    public function __construct()
    {
    }

    /**
    * メンバー取得
    *
    * @return array 削除しタスクを返却
    */
    public function getFollowers()
    {
        $followers = Follower::get();
        return $followers;
    }

    /**
    * メンバー個人取得
    *
    * @return array 削除しタスクを返却
    */
    public function getFollower(Request $request)
    {
        $follower = Follower::with(['messages', 'tasks'])
            ->where('followers.mid', $request->mid)
            ->first();
        Log::debug(print_r($follower, true));
        return $follower;
    }
}