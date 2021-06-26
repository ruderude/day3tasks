<?php

namespace App\Support;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Line
{
    public static function get_profile(string $mid): array
    {
        $curl = curl_init("https://api.line.me/v2/bot/profile/$mid");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".env("LINE_BOT_SECRET_TOKEN"),
        ]);
        $json = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($json, true);

        return [
            "name" => $data["displayName"] ?? "",
            "icon_url" => $data["pictureUrl"] ?? "",
        ];
    }
}
