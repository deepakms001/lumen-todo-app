<?php


namespace App\Features;

use App\Models\Category;
use App\Operations\Auth\UserPermissionCheck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetCategoryFeature
{
    public function run(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            throw new Exception('Category not found', 404);
        }
        (new UserPermissionCheck())->run($request->auth, $category);
        return (new JsonResponse([
            'status' => 'success',
            'category' => $category
        ], 200));
    }
}
