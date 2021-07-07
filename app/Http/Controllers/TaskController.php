<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;
use App\Support\Line;

class TaskController extends Controller
{
    private $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }


    /**
    * タスク新規登録処理
    *  
    * @param Request $request リクエスト
    * @return array 保存し内容を返却
    */
    public function store(Request $request): array
    {
        Log::debug(print_r($request->all(), true));

        $forms = $request["forms"];
        $access_token = $request["access_token"];
        $user = Line::get_profile($access_token);
        $mid = $user['mid'];
        $this->service->store($forms, $mid);
        $tasks = $this->service->getTodayTasks($mid);
        // Log::debug(print_r($tasks, true));

        return $tasks;
    }

    /**
    * タスク更新処理
    *  
    * @param Request $request リクエスト
    * @return array 更新し内容を返却
    */
    public function update(Request $request): array
    {
        // Log::debug(print_r($request->all(), true));
        $tasks = $request["tasks"];
        $mid = $tasks['mid'];
        $this->service->update($tasks, $mid);
        $tasks = $this->service->getTodayTasks($mid);
        // Log::debug(print_r($tasks, true));

        return $tasks;
    }

    public function setTasks(Request $request)
    {
        // Log::debug('ゲットユーザー：' . print_r($request->all(), true));
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
        // Log::debug('ユーザー情報：' . print_r($user, true));
        $tasks = $this->service->getTodayTasks($user["mid"]);
        // Log::debug('今日のタスク：' . print_r($tasks, true));

        return $tasks;
    }

    public function changeDone(Request $request)
    {
        $id = $request->post('id');
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
        $this->service->changeDone($id, $user["mid"]);
        $tasks = $this->service->getTodayTasks($user["mid"]);

        return $tasks;
    }
    
}
