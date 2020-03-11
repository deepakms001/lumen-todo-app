<?php

namespace App\Operations\Auth;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Signup
{
    public function run(array $fields)
    {
        $user = new User();
        $user->first_name = $fields['first_name'];
        $user->last_name = $fields['last_name'];
        $user->mobile_number = $fields['mobile_number'];
        $user->email = $fields['email'];
        $user->password = Hash::make($fields['password']);
        $user->gender = $fields['gender'];
        if ($user->save()) {
            return $user;
        }
        throw new Exception('Unable to signup', 400);
    }
}
