<?php

namespace App\Operations\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateSignup
{
    private $validatorArray;

    public function __construct()
    {
        $this->validatorArray = [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:8',
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
        return [];
    }
}
