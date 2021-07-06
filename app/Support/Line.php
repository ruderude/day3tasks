<?php

namespace App\Support;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Line
{
    public static function get_profile(String $access_token): array
    {
        // Log::debug('アクセストークン：' . print_r($access_token, true));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/profile');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $userdata = json_decode($response);
        $data = [
            "name" => $userdata->displayName,
            "mid" => $userdata->userId,
            "icon_url" => $userdata->pictureUrl,
        ];

        return $data;
    }
}
