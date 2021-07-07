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
    * @param array $tasks タスク
    * @param string $access_token アクセストークン
    * @return array 保存し内容を返却
    */
    public function store(array $forms, string $mid): void
    {
        // Log::debug('ストア' . print_r($forms, true));
        $tasks = $this->trim($forms);
        $this->repository->store($tasks, $mid);
    }

    /**
    * 今日のタスク取得
    *  
    * @param array $tasks タスク
    * @param string $mid mid
    * @return array タスクを返却
    */
    public function getTodayTasks(string $mid): array
    {
        return $this->repository->getTodayTasks($mid);
    }
    
}