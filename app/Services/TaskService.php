<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Support\Line;
use Illuminate\Support\Facades\Log;

class TaskService
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
    * タスクトリム処理
    *  
    * @param Request $request リクエスト
    * @return array タスクを整理し内容を返却
    */
    public function trim(array $forms): array
    {
        $tasks = [];
        foreach($forms as $task) {
            $task['title'] = isset($task['title']) ? trim(mb_convert_kana($task['title'], "s", 'UTF-8')) : "";
            if($task['title']) {
                $tasks[] = $task;
            }
        }

        return $tasks;
    }

    /**
    * タスク新規登録処理
    *  
    * @param array $forms タスク
    * @param string $mid mid
    * @return void 保存
    */
    public function store(array $forms, string $mid): void
    {
        // Log::debug('ストア' . print_r($forms, true));
        $tasks = $this->trim($forms);
        $this->repository->store($tasks, $mid);
    }

    /**
    * タスク更新処理
    *  
    * @param array $tasks タスク
    * @return void 更新
    */
    public function update(array $tasks): void
    {
        $tasks['title'] = isset($tasks['title']) ? trim(mb_convert_kana($tasks['title'], "s", 'UTF-8')) : "";
        if(!$tasks['title']){exit;}
        $this->repository->update($tasks);
    }

    /**
    * 今日のタスク取得
    *  
    * @param string $mid mid
    * @return array タスクを返却
    */
    public function getTodayTasks(string $mid): array
    {
        return $this->repository->getTodayTasks($mid);
    }

    /**
    * 過去のタスク取得
    *  
    * @param string $mid mid
    * @return array タスクを返却
    */
    public function getOldTasks(string $mid): array
    {
        return $this->repository->getOldTasks($mid);
    }

    /**
    * doneの入れ替え
    *  
    * @param array $tasks タスク
    * @param int $id タスクid
    * @return void
    */
    public function changeDone(int $id): void
    {
        $this->repository->changeDone($id);
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
        $this->repository->delete($id, $mid);
    }
    
}