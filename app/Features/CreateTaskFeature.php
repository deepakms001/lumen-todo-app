<?php


namespace App\Features;

use App\Models\Category;
use App\Models\Task;
use App\Operations\Auth\DataDuplicationCheck;
use App\Operations\Auth\UserPermissionCheck;
use App\Operations\Category\CreateCategory;
use App\Operations\Task\CreateTask;
use App\Operations\Task\ValidateCreateTask;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateTaskFeature
{
    public function run(Request $request)
    {
        $validation = (new ValidateCreateTask())->run($request);
        if ($validation !== true) {
            $result = (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            $data = $request->all();
            if (isset($data['category_id']) && $data['category_id']) {
                $category = Category::find($data['category_id']);
                if (!$category) {
                    throw new Exception('Category not found');
                }
                (new UserPermissionCheck())->run($request->auth, $category);
            } else if (isset($data['category_name']) && $data['category_name']) {
                $category = Category::where('name', $data['category_name'])
                    ->where('user_id', $request->auth->id)->first();
                if (!$category) {
                    $category = (new CreateCategory())->run([
                        'name' => $data['category_name'],
                        'user_id' => $request->auth->id
                    ]);
                    if(!$category){
                        throw new Exception('Unable to create category.',400);
                    }
                }
                $data['category_id'] = $category->id;
            }

            if (isset($data['category_name']) && $data['category_name']) {
                $category = Category::where('name', $data['category_name'])
                ->where('user_id',$request->auth->id)->first();
                if (!$category) {
                    throw new Exception('Category not found');
                }
                $data['category_id'] = $category->id;
            }

            $task = (new CreateTask())->run($data);
            if (isset($task->id)) {
                $result = (new JsonResponse([
                    'status' => 'success',
                    'message' => 'Task created successfully.',
                    'data' => $task->load('category')
                ], 200));
            } else {
                throw new Exception('Unable to create task.', 400);
            }
        }
        return $result;
    }
}
