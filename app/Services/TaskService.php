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
    * @return array 保存し内容を返却
    */
    public function store(array $forms, array $access_token): array
    {
        // Log::debug('ストア' . print_r($forms, true));
        $tasks = $this->trim($forms);
        $user = Line::get_profile($access_token);
        $mid = $user['mid'];
        $this->repository->store($tasks, $mid);
        // Log::debug('ストア' . print_r($tasks, true));
        return $tasks;
    }
}