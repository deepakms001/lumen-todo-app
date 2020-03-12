<?php

namespace App\Operations\Task;

use App\Models\Task;

class CreateTask
{
    public function run(array $fields)
    {
        $task = new Task();
        $task->name = $fields['name'];
        $task->description = $fields['description'];
        $task->date_time = $fields['date_time'];
        $task->category_id = $fields['category_id'];
        $task->status = $fields['status'];
        $task->save();
        return $task;
    }
}
