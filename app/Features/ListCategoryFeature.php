<?php


namespace App\Features;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListCategoryFeature
{
    public function run(Request $request)
    {
        $count = $request->input('count');
        $data = Category::where('user_id', $request->auth->id)
            ->paginate($count ? $count : 10);
        return (new JsonResponse([
            'status' => 'success',
            'data' => $data
        ], 200));
    }
}
