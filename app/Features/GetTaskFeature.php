<?php


namespace App\Features;

use App\Models\Task;
use App\Operations\Auth\UserPermissionCheck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetTaskFeature
{
    public function run(Request $request, $taskId)
    {
        $task = Task::with('category')->find($taskId);
        if (!$task) {
            throw new Exception('Task not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $task);
        return (new JsonResponse([
            'status' => 'success',
            'task' => $task
        ], 200));
    }
}
