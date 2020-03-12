<?php

namespace App\Operations\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateUpdateTask
{
    private $validatorArray;

    public function __construct()
    {
        $this->validatorArray = [
            'name' => 'max:255',
            'description' => 'max:255',
            'date_time' => 'date_format:Y-m-d H:i:s',
            'category_id' => 'numeric',
            'category_name' => 'min:1|max:255',
            'status' => 'required|in:Completed,Snoozed,Overdue'
        ];
    }

    public function run(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->validatorArray
        );
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }
}
