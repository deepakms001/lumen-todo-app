<?php

namespace App\Operations\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateCreateCategory
{
    private $validatorArray;

    public function __construct()
    {
        $this->validatorArray = [
            'name' => 'required'
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
