<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodayController extends Controller
{
    public function store(Request $request)
    {
        Log::debug(print_r($request->all(), true));
        $data = [
            "test1" => "tteesstt1",
            "test2" => "tteesstt2",
            "test3" => "tteesstt3",
        ];
        return $data;
    }
}
