<?php


namespace App\Features;

use App\Models\Category;
use App\Operations\Auth\UserPermissionCheck;
use App\Operations\Category\ValidateCreateCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateCategoryFeature
{
    public function run(Request $request,  $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            throw new Exception('Category not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $category);
        $validation = (new ValidateCreateCategory())->run($request);
        if ($validation !== true) {
            $result = (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            $category->name = $request->input('name');
            if ($category->save()) {
                $result = (new JsonResponse([
                    'status' => 'success',
                    'message' => 'Category updated successfully.',
                    'category' => $category
                ], 200));
            }
        }
        return $result;
    }
}
