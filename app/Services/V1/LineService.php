<?php

namespace App\Services\V1;

use App\Repositories\MessageRepository;
use App\Repositories\FollowerRepository;
use App\Support\Line;
use App\Consts\ReplyList;
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

    // ユーザーの操作によって処理を分岐
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
                // Log::debug("switch通過");
                $this->_text($mid, $data, $type, $reply_token);
                break;
            case "image":
                $data = $this->_get_content($data);
                $this->_image($mid, $data, $type, $reply_token);
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
        $reply_array = ReplyList::REPLY_LIST;
        $key = array_rand($reply_array, 1);
        $res[] = [
            "type" => "text",
            "text" => $reply_array[$key]
        ];
        $data = [
            "replyToken" => $reply_token,
            "messages" => $res,
        ];
        Log::debug('メッセージ：' . print_r($messages, true));
        Log::debug('送信データ：' . print_r($data, true));

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

    private function _text(string $mid, string $data, string $type, string $reply_token): void
    {
        // Log::debug("text通過");
        $messages = [];
        $messages[] = [
            "type" => "text",
            "text" => $data,
        ];

        $this->_reply($messages, $reply_token);
        $id = $this->messageRepository->receive($mid, $type, $data);
    }

    private function _image(string $mid, string $data, string $type, string $reply_token): void
    {
        $id = $this->messageRepository->receive($mid, $type, $data);
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

    /**
     * フォロー処理
     * 
     * @param string $mid
     * @param string $reply_token
     * @return void
     */
    public function follow(string $mid, string $reply_token): void
    {
        $data = $this->_get_profile($mid);
        Log::debug('データ：' . print_r($data, true));
        $this->followerRepository->follow($mid, $data["displayName"], $data["pictureUrl"]);

        // TODO
        // フォロー時の動作
        // $this->_reply($data, $reply_token);
    }

    /**
     * フォロー解除処理
     * 
     * @param string $mid
     * @return void
     */
    public function unfollow(string $mid): void
    {
        $this->followerRepository->unfollow($mid);
    }

    /**
     * フォロワーがLINEに設定してるアイコンや名前などの情報を取得する関数
     *
     * @see https://developers.line.biz/ja/reference/messaging-api/#get-profile
     * @param string $mid
     * @return array
     */
    protected function _get_profile(string $mid): array
    {
        $access_token = env("LINE_ACCESS_TOKEN");
        // Log::debug('アクセスとーけん：' . print_r($access_token, true));
        $curl = curl_init("https://api.line.me/v2/bot/profile/$mid");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $access_token",
        ]);
        $json = curl_exec($curl);
        curl_close($curl);

        return json_decode($json, true);
    }

}
