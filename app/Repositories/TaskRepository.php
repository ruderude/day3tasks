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
        //  Log::debug("レポジトリ" . print_r($tasks, true));
        try {
            DB::beginTransaction();

            foreach ($tasks as $task) {
                $created = Task::make();
                $created->mid = $mid;
                $created->title = $task["title"];
                $created->detail = $task["detail"] ?? "";
                $created->done = $task["done"] ?? false;
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
     * @return
     */
    public function getTodayTasks(string $mid)
    {
        $columns = [
            "id",
            "mid",
            "title",
            "detail",
            "done",
            "created_at",
        ];
        return Task::select($columns)
            ->where("mid", "=", $mid)
            ->where('created_at', '>=', Carbon::today())
            ->whereNull('deleted_at')
            ->get();
    }

    /**
     * 過去のタスクを取得する
     *
     * @param string $mid
     * @return array
     */
    public function getOldTasks(string $mid)
    {
        $columns = [
            "id",
            "mid",
            "title",
            "detail",
            "done",
            "created_at",
        ];
        return Task::select()
            ->where("mid", "=", $mid)
            ->where('created_at', '<', Carbon::today())
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by days
            })
            ->toArray();
    }

    /**
     * doneを入れ替える
     *
     * @param int $id
     * @return array $task
     */
    public function changeDone(int $id)
    {
        $task = Task::find($id);
        $task->done = !$task->done;

        try {
            DB::beginTransaction();

            Task::where('id', $id)->update(['done' => $task->done]);

            DB::commit();
        } catch (Exception $e) {
            Log::error('タスクレポジトリ' . $e->getMessage());
            DB::rollBack();
        }
        return $task;
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
