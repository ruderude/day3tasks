<?php

namespace App\Repositories;

use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskRepository
{
    public function store(array $tasks, string $mid): void
    {
        Log::debug("レポジトリ" . print_r($tasks, true));
        try {
            DB::beginTransaction();

            foreach ($tasks as $task) {
                $created = Task::make();
                $created->mid = $mid;
                // $created->mid = isset($task["mid"]) ? $task["mid"] : "testtest";
                $created->title = $task["title"];
                $created->detail = isset($task["detail"]) ? $task["detail"] : "";
                $created->done = isset($task["done"]) ? $task["done"] : false;
                $created->save();
            }

            DB::commit();
        } catch (Exception $e) {
            Log::debug('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
        Log::debug("レポジトリ完了");
    }
}
