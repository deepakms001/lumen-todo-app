<?php

namespace App\Operations\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateSignin
{
    private $validatorArray;

    public function __construct()
    {
        $this->validatorArray = [
            'email' => 'required|email|exists:users',
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
