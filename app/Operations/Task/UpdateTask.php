<?php

namespace App\Operations\Task;

use App\Models\Task;
use Exception;

class UpdateTask
{
    public function run(Task $task, $attributes)
    {
        $task->name = $attributes['name'];
        if ($task->save()) {
            return $task;
        }
        throw new Exception('Unable to create task.');
    }
}
