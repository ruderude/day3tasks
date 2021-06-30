<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class LiffController extends Controller
{
    public function today(): View
    {
        return view('liff.start');
        // return view('liff.today');
    }

    public function history(): View
    {
        return view('liff.history');
    }

    public function getAccessToken($accessToken)
    {
        Log::debug('アクセストークン：' . $accessToken);
        exit;
    }
}
