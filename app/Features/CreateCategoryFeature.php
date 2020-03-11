<?php


namespace App\Features;

use App\Operations\Category\CreateCategory;
use App\Operations\Category\ValidateCreateCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateCategoryFeature
{
    public function run(Request $request)
    {
        $validation = (new ValidateCreateCategory())->run($request);
        if ($validation !== true) {
            $result = (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            $data = $request->all();
            $data['user_id'] = $request->auth->id;
            $category = (new CreateCategory())->run($data);
            if (isset($category->id)) {
                $result = (new JsonResponse([
                    'status' => 'success',
                    'message' => 'Category created successfully.',
                    'data' => $category
                ], 200));
            } else {
                throw new Exception('Unable to delete category.', 400);
            }
        }
        return $result;
    }
}
