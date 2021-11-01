<?php

namespace App\Repositories;

use App\Models\Message;
use App\Support\Flag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageRepository
{
    public function index()
    {
        $columns = [
            "users.id AS user_id",
            "users.name",
            "messages.id",
            "messages.type",
            "messages.text",
            "messages.created_at",
        ];
        return Message::select($columns)
            ->join("users", "users.id", "messages.user_id")
            ->where("messages.dest", null)
            ->whereNotNull("messages.user_id")
            ->whereNull("messages.deleted_at")
            ->get();
    }

    public function count(): int
    {
        return Message::select()
            ->where("dest", null)
            ->where("already", Flag::off)
            ->count();
    }

    public function receive(string $mid, string $type, ?string $text = null): ?int
    {
        $id = null;
        $to = null;

        try {
            DB::beginTransaction();

            $message = Message::make();
            $message->mid = $mid;
            $message->dest = $to;
            $message->type = $type;
            $message->text = $text;
            $message->save();

            $id = $message->id;

            DB::commit();
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $id;
    }

}
