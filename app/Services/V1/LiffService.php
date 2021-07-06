<?php

namespace App\Services\V1;

use App\Repositories\TaskRepository;
use App\Support\Line;
use Illuminate\Support\Facades\Log;

class LiffService
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTodayTasks(string $mid): array
    {
        return $this->taskRepository->getTodayTasks($mid);
    }

}
