<?php

namespace App\Service;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Termwind\Actions\StyleToMethod;

class TaskService extends Controller
{

    public function store(array $data): JsonResponse
    {
        try {
            $task = Task::firstOrCreate($data);
            return response()->json(['task'=>$task]);
        }
        catch (Exception $exception){
            return response()->json(['error_message'=>$exception]);
        }
    }
    public function filter(array $data): array|Collection
    {
        $query = Task::query();

        // Фильтр по статусу
        if ($status = $data['status'] ?? null) {
            $query->where('status', $status);
        }

        // Фильтр по дате
        if ($startDate = $data['date'] ?? null) {
            $query->where('created_at', '>=', $startDate);
        }
        $filteredTask = $query->get();

        return $filteredTask;

    }

    public function update($data,$id){
        $feedback = Task::find($id);
        return $feedback->update($data);
    }
}
