<?php


namespace App\Features;

use App\Models\Task;
use App\Operations\Auth\UserPermissionCheck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteTaskFeature
{
    public function run(Request $request, $taskId)
    {
        $task = Task::find($taskId);
        if (!$task) {
            throw new Exception('Category not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $task);
        if ($task->delete()) {
            $result = (new JsonResponse([
                'status' => 'success',
                'message' => 'Task delete successfully.'
            ], 200));
        } else {
            throw new Exception('Unable to delete task.', 400);
        }
        return $result;
    }
}
