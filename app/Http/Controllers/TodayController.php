<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;

class TodayController extends Controller
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

        $tasks = $this->service->store($request);
        // Log::debug(print_r($tasks, true));

        return $tasks;
    }
    
}
