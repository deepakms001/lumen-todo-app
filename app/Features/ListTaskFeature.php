<?php


namespace App\Features;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListTaskFeature
{
    public function run(Request $request)
    {
        $count = $request->input('count');

        $name = $request->input('name');
        $desc = $request->input('description');
        $start = $request->input('start');
        $end = $request->input('end');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');
        $categoryName = $request->input('category_name');

        $orderBy = $request->input('orderBy') ? $request->input('orderBy') : 'date_time';
        $order = $request->input('order') ? $request->input('order') : 'desc';

        $user = $request->auth;
        $tasksQry = Task::with('category')->whereHas('category', function ($q) use ($user, $categoryName) {
            $q->where('user_id', $user->id);
            if ($categoryName) {
                $q->where('name', $categoryName);
            }
            return $q;
        });

        if ($name) {
            $tasksQry->where('name', $name);
        }
        if ($desc) {
            $tasksQry->where('description', $desc);
        }
        if ($categoryId) {
            $tasksQry->where('category_id', $categoryId);
        }
        if ($status) {
            $tasksQry->where('status', $status);
        }

        if ($start) {
            $tasksQry->where('date_time', '>=', Carbon::parse($start));
        }
        if ($end) {
            $tasksQry->where('date_time', '<=', Carbon::parse($end));
        }

        $data = $tasksQry->orderBy($orderBy, $order)->paginate($count ? $count : 10);
        return (new JsonResponse(['status' => 'success', 'data' => $data], 200));
    }
}
