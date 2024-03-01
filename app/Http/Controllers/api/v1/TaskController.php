<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\FilterRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Service\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected  TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function filter(FilterRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        return TaskResource::collection($this->taskService->filter($data));
    }
    public function index(int $perPage): AnonymousResourceCollection
    {
        $feedback = Task::select('id','name','description','status','created_at')->paginate($perPage);
        return TaskResource::collection($feedback);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        return $this->taskService->store($data);
    }

    public function update(UpdateRequest $request,int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $this->taskService->update($data, $id);

            return response()->json(['data' => $data]);
        } catch (Exception $exception) {
            return response()->json(['error_message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json(['message' => 'Успешно удаленно'], 204);
    }
}
