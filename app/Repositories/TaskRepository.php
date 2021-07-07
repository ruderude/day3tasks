<?php

namespace App\Repositories;

use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskRepository
{
    /**
    * タスク作成
    *  
    * @param Request $request リクエスト
    * @return array タスクを整理し内容を返却
     */
    public function store(array $tasks, string $mid): void
    {
        // Log::debug("レポジトリ" . print_r($tasks, true));
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
    }

    /**
     * 今日のタスクを取得する
     * 
     * @param string $mid
     * @return array
     */
    public function getTodayTasks($mid): array
    {
        return Task::select()
            ->where("mid", "=", $mid)
            ->where('created_at', '>=', Carbon::today())
            ->get()
            ->toArray();
    }

    /**
     * doneを入れ替える
     * 
     * @param int $id
     * @param string $mid
     * @return void
     */
    public function changeDone(int $id, string $mid): void
    {
        $task = Task::find($id);
        $done = $task->done ? false : true;

        try {
            DB::beginTransaction();

            Task::where('id', $id)->update(['done' => $done]);

            DB::commit();
        } catch (Exception $e) {
            Log::debug('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
    }
}
