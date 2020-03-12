<?php


namespace App\Features;

use App\Models\Category;
use App\Models\Task;
use App\Operations\Auth\UserPermissionCheck;
use App\Operations\Category\CreateCategory;
use App\Operations\Task\CreateTask;
use App\Operations\Task\UpdateTask;
use App\Operations\Task\ValidateUpdateTask;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTaskFeature
{
    public function run(Request $request, $taskId)
    {
        $user = $request->auth;;
        $data = $request->all();
        $task = Task::find($taskId);
        if (!$task) {
            throw new Exception('Task not found', 404);
        }
        (new UserPermissionCheck())->run($user, $task);
        $validation = (new ValidateUpdateTask())->run($request);
        if ($validation !== true) {
            return (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        }
        if (isset($data['category_id']) && $data['category_id']) {
            $category = Category::find($data['category_id']);
            if (!$category) {
                throw new Exception('Category not found');
            }
            (new UserPermissionCheck())->run($user, $category);
        } else if (isset($data['category_name']) && $data['category_name']) {
            $category = Category::where('name', $data['category_name'])
                ->where('user_id', $user->id)->first();
            if (!$category) {
                $category = (new CreateCategory())->run([
                    'name' => $data['category_name'],
                    'user_id' => $user->id
                ]);
                if (!$category) {
                    throw new Exception('Unable to create category.', 400);
                }
            }
            $data['category_id'] = $category->id;
        }

        if (isset($data['category_name']) && $data['category_name']) {
            $category = Category::where('name', $data['category_name'])
                ->where('user_id', $user->id)->first();
            if (!$category) {
                throw new Exception('Category not found');
            }
            $data['category_id'] = $category->id;
        }

        $task = (new UpdateTask())->run($task, $data);
        if (isset($task->id)) {
            $result = (new JsonResponse([
                'status' => 'success',
                'message' => 'Task created successfully.',
                'data' => $task->load('category')
            ], 200));
        } else {
            throw new Exception('Unable to create task.', 400);
        }

        return $result;
    }
}
