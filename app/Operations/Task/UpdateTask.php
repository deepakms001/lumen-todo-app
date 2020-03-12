<?php

namespace App\Operations\Task;

use App\Models\Task;
use Exception;

class UpdateTask
{
    public function run(Task $task, $attributes)
    {
        if (isset($attributes['name'])) {
            $task->name = $attributes['name'];
        }
        if (isset($attributes['description'])) {
            $task->description = $attributes['description'];
        }
        if (isset($attributes['date_time'])) {
            $task->date_time = $attributes['date_time'];
        }
        if (isset($attributes['category_id'])) {
            $task->category_id = $attributes['category_id'];
        }
        if (isset($attributes['status'])) {
            $task->status = $attributes['status'];
        }

        if ($task->save()) {
            return $task;
        }
        throw new Exception('Unable to update task.');
    }
}
