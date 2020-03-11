<?php

namespace App\Operations\Task;

use App\Models\Task;

class CreateTask
{
    public function run(array $fields)
    {
        $task = new Task();
        $task->name = $fields['name'];
        $task->user_id = $fields['user_id'];
        $task->save();
        return $task;
    }
}
