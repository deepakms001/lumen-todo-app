<?php


namespace App\Features;

use App\Models\Task;
use App\Operations\Auth\UserPermissionCheck;
use App\Operations\Task\ValidateCreateTask;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTaskFeature
{
    public function run(Request $request,  $taskId)
    {
        $task = Task::find($taskId);
        if (!$task) {
            throw new Exception('Task not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $task);
        $validation = (new ValidateCreateTask())->run($request);
        if ($validation !== true) {
            $result = (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            $task->name = $request->input('name');
            if ($task->save()) {
                $result = (new JsonResponse([
                    'status' => 'success',
                    'message' => 'Task updated successfully.',
                    'task' => $task
                ], 200));
            }
        }
        return $result;
    }
}
