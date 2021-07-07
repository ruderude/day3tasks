<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Support\Line;
use App\Services\V1\LiffService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class LiffController extends Controller
{

    private $service;

    public function __construct(LiffService $service)
    {
        $this->service = $service;
    }

    public function today(): View
    {
        return view('liff.today');
    }

    public function history(): View
    {
        return view('liff.history');
    }

    public function getAccessTokenget(Request $request)
    {
        Log::debug('ゲット：' . print_r($request->all(), true));
        $data = [
            "message" => $request->text
        ];
        // Log::debug('データ：' . print_r($data, true));
        return $data;
    }

    public function getAccessTokenpost(Request $request)
    {
        Log::debug('ポスト：' . print_r($request->all(), true));
        $data = [
            "message" => $request->text
        ];
        // Log::debug('データ：' . print_r($data, true));
        return $data;
    }

}
