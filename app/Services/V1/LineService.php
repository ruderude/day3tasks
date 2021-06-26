<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use App\Repositories\FollowerRepository;
use App\Support\Line;
use Illuminate\Support\Facades\Log;

class LineService
{
    private $messageRepository;
    private $followerRepository;

    public function __construct(MessageRepository $messageRepository, FollowerRepository $followerRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->followerRepository = $followerRepository;
    }

    public function entry(?string $reply_token, string $mid, string $type, ?string $data): void
    {
        switch ($type) {
            case "follow":
                $this->follow($mid, $reply_token);
                break;
            case "unfollow":
                $this->unfollow($mid);
                break;
            case "text":
                Log::debug("switch通過");
                $this->_text($mid, $data, $reply_token);
                break;
            case "image":
                $data = $this->_get_content($data);
                $this->_image($mid, $data, $reply_token);
                break;
            case "postback":
                // ポストバックデータを解析
                parse_str($data, $data); // ここで配列に変換してるので警告が出てても問題ない
                $this->_postback($reply_token, $mid, $data);
                break;
        }
    }

    private function _reply(array $messages, string $reply_token): void
    {
        $data = [
            "replyToken" => $reply_token,
            "messages" => $messages,
        ];

        $json = json_encode($data);
        $curl = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json; charset=UTF-8",
            "Authorization: Bearer ".env("LINE_ACCESS_TOKEN"),
        ]);
        $r = curl_exec($curl);
        curl_close($curl);
    }

    private function _text(string $mid, string $data, string $reply_token): void
    {
        Log::debug("text通過");
        // $messages = [];
        // $messages[] = [
        //     "type" => "text",
        //     "text" => $data,
        // ];
        // $this->_reply($messages, $reply_token);
        if (isset($params["type"])) {
            switch ($params["type"]) {
                default:
                    break;
            }
        }
        else {
            $this->messageRepository->receive($mid, config("define.line.message.type.text"), $data);
        }
    }

    private function _image(string $mid, string $data, string $reply_token): void
    {
        $id = $this->messageRepository->receive($mid, config("define.line.message.type.image"));
        file_put_contents(storage_path("app/public/messages/$id.jpg"), $data);
    }

    private function _get_content(int $id): string
    {
        $header = [
            "Authorization: Bearer ".env("LINE_ACCESS_TOKEN"),
        ];
        $context = [
            "http" => [
                "method" => "GET",
                "header" => implode("\\r\\n", $header),
                "ignore_errors" => true,
            ],
        ];

        return file_get_contents("https://api-data.line.me/v2/bot/message/$id/content", false, stream_context_create($context));
    }

    public function follow(string $mid, string $reply_token): void
    {
        $data = Line::get_profile($mid);
        $this->followerRepository->follow($mid, $data["name"], $data["icon_url"]);

        // $data = [];

        // TODO
        // フォロー時の動作

        $this->_reply($data, $reply_token);
    }

    public function unfollow(string $mid): void
    {
        $this->followerRepository->unfollow($mid);
    }

}
