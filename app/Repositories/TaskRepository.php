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
    * @param array $tasks タスク
    * @param string $mid mid
    * @return void タスクを保存
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
            Log::error('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
    }

    /**
    * タスク更新
    *  
    * @param array $tasks タスク
    * @return void タスクを更新
     */
    public function update(array $tasks): void
    {
        $tasks['done'] = $tasks['done'] ? 1 : 0;
        // Log::error("レポジトリ" . print_r($tasks, true));
        try {
            DB::beginTransaction();

            Task::where('id', $tasks['id'])->update([
                'title' => $tasks['title'],
                'detail' => $tasks['detail'],
                'done' => $tasks['done'],
            ]);

            DB::commit();
        } catch (Exception $e) {
            Log::error('タスクレポジトリ' . $e->getMessage());
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
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    /**
     * 過去のタスクを取得する
     * 
     * @param string $mid
     * @return array
     */
    public function getOldTasks($mid): array
    {
        return Task::select()
            ->where("mid", "=", $mid)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    /**
     * doneを入れ替える
     * 
     * @param int $id
     * @return void
     */
    public function changeDone(int $id): void
    {
        $task = Task::find($id);
        $done = $task->done ? false : true;

        try {
            DB::beginTransaction();

            Task::where('id', $id)->update(['done' => $done]);

            DB::commit();
        } catch (Exception $e) {
            Log::error('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
    }

    /**
    * タスク削除
    *  
    * @param int $id タスクid
    * @param string $mid mid
    * @return void
    */
    public function delete(int $id, string $mid): void
    {
        // 本人のリクエストか確認
        $task = Task::find($id);
        if($task->mid !== $mid){
            Log::error("midが一致しません");
            exit;
        }
        try {
            DB::beginTransaction();

            Task::destroy($id);

            DB::commit();
        } catch (Exception $e) {
            Log::error('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
    }
}
