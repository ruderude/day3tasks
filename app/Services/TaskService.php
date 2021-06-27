<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
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
    public function trim(Request $request)
    {
        $tasks = [];
        foreach($request->all() as $task) {
            $task['title'] = isset($task['title']) ? trim(mb_convert_kana($task['title'], "s", 'UTF-8')) : "";
            if($task['title']) {
                $tasks[] = $task;
            }
            // Log::debug($title);
        }

        return $tasks;
    }

    /**
    * タスク新規登録処理
    *  
    * @param array $tasks タスク
    * @return array 保存し内容を返却
    */
    public function store(array $tasks): array
    {
        // Log::debug(print_r($request->all(), true));
        $tasks = $this->service->trim($request);

        return $data;
    }
}