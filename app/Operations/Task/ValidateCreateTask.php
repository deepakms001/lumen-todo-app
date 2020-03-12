<?php

namespace App\Operations\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateCreateTask
{
    private $validatorArray;

    public function __construct()
    {
        $this->validatorArray = [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'date_time' => 'date_format:Y-m-d H:i:s',
            'category_id' => 'numeric|required_if:category_name,""',
            'category_name' => 'min:1|max:255|required_if:category_id,""',
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
