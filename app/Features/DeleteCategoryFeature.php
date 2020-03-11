<?php


namespace App\Features;

use App\Models\Category;
use App\Operations\Auth\UserPermissionCheck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteCategoryFeature
{
    public function run(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            throw new Exception('Category not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $category);
        if ($category->delete()) {
            $result = (new JsonResponse([
                'status' => 'success',
                'message' => 'Category delete successfully.'
            ], 200));
        } else {
            throw new Exception('Unable to delete category.', 400);
        }
        return $result;
    }
}
