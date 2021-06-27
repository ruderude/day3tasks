<?php

namespace App\Http\Controllers\V1;

use App\Services\V1\LineService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    private $service;

    public function __construct(LineService $service)
    {
        $this->service = $service;
    }

    public function entry(): Response
    {
        Log::debug('エントリー');
        $json = json_decode(file_get_contents("php://input"), true);
        if ($json == null) {
            return response("NOT FOUND", 404);
        }

        if (count($json["events"]) === 0) {
            return response("", 200);
        }

        Log::debug(print_r($json,true));

        $event = $json["events"][0];
        $mid = $event["source"]["userId"];
        $type = $event["message"]["type"] ?? $event["type"];
        $reply_token = $event["replyToken"] ?? null;
        $data = $event["message"]["text"] ?? $event["postback"]["data"] ?? $event["beacon"]["type"] ?? null;

        if (is_null($data)) {
            if ($type === "image" || $type === "video") {
                $data = $event["message"]["id"];
            }
            if ($type === "location") {
                $data = json_encode($event["message"]);
            }
        }

        if (is_null($mid) || is_null($type)) {
            return response("NOT FOUND", 404);
        }

        Log::debug(print_r($data,true));

        $this->service->entry($reply_token, $mid, $type, $data);

        return response("OK");

    }

}
