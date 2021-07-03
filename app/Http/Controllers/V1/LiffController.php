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

    public function getUser(Request $request)
    {
        $access_token = $request->post('accessToken');
        Log::debug('アクセストークン：' . print_r($access_token, true));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/profile');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $userdata = json_decode($response);
        $data = [
            "名前：" => $userdata->displayName,
            "ID：" => $userdata->userId,
            "アイコン：" => $userdata->pictureUrl,
        ];
        Log::debug('アクセストークン：' . print_r($data, true));

        return $request->all();
    }
}
