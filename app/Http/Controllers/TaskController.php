<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;
use App\Support\Line;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;

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
    * @param TaskStoreRequest $request リクエスト
    * @return array 保存し内容を返却
    */
    public function store(TaskStoreRequest $request): array
    {
//        Log::debug(print_r($request->all(), true));

        $forms = $request["forms"];
        $access_token = $request["access_token"];
        $user = Line::get_profile($access_token);
        $mid = $user['mid'];
        // Log::debug(print_r($mid, true));
        $this->service->store($forms, $mid);
        // Log::debug(print_r($tasks, true));

        return $this->service->getTodayTasks($mid);
    }

    /**
    * タスク更新処理
    *
    * @param TaskUpdateRequest $request リクエスト
    * @return array 更新し内容を返却
    */
    public function update(TaskUpdateRequest $request): array
    {
        // Log::debug(print_r($request->all(), true));
        $tasks = $request["tasks"];
        $mid = $tasks['mid'];
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);

        // 本人のリクエストか確認
        if(!Line::checkMid($user["mid"], $mid)){
            Log::error("midが一致しません");
            exit;
        }

        $this->service->update($tasks);
        // Log::debug(print_r($tasks, true));

        return $this->service->getTodayTasks($user["mid"]);
    }

    /**
    * ユーザー情報を取得して今日のタスクを取得
    *
    * @param Request $request リクエスト
    * @return array 内容を返却
    */
    public function setTasks(Request $request): array
    {
        // Log::debug('ゲットユーザー：' . print_r($request->all(), true));
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
        // Log::debug('ユーザー情報：' . print_r($user, true));
        // Log::debug('今日のタスク：' . print_r($tasks, true));

        return $this->service->getTodayTasks($user["mid"]);
    }

    /**
    * ユーザー情報を取得して過去のタスクを取得
    *
    * @param Request $request リクエスト
    * @return array 内容を返却
    */
    public function oldTasks(Request $request): array
    {
         Log::debug('ゲットユーザー：' . print_r($request->all(), true));
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
//        Log::debug('ユーザー情報：' . print_r($user, true));
        $tasks = $this->service->getOldTasks($user["mid"]);
        Log::debug('タスク情報：' . print_r($tasks, true));
        return $tasks;
    }

    /**
    * タスクの完了未完了入れ替え
    *
    * @param Request $request リクエスト
    * @return array 内容を返却
    */
    public function changeDone(Request $request): array
    {
        $id = $request->post('id');
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
        $task = $this->service->changeDone($id);
        return $this->service->getTodayTasks($user["mid"]);
    }

    /**
     * タスクの完了未完了入れ替え履歴用
     * 今日のラスクを返却しない
     *
     * @param Request $request リクエスト
     * @return array 内容を返却
     */
    public function oldChangeDone(Request $request): array
    {
//        Log::debug('オールドDONE：' . print_r($request->all(), true));
        $id = $request->post('id');
        return $this->service->changeDone($id);
//        Log::debug('オールドDONE返却：' . print_r($task, true));
    }

    /**
    * タスク削除処理
    *
    * @param Request $request リクエスト
    * @return array 削除しタスクを返却
    */
    public function delete(Request $request): array
    {
        $id = $request->post('id');
        $access_token = $request->post('access_token');
        $user = Line::get_profile($access_token);
        $this->service->delete($id, $user["mid"]);
        return $this->service->getTodayTasks($user["mid"]);
    }

}
