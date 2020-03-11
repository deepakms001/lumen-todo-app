<?php


namespace App\Features;

use App\Operations\Auth\Signin;
use App\Operations\Auth\ValidateSignin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SigninFeature
{
    public function run(Request $request)
    {
        $validation = (new ValidateSignin())->run($request);
        if (count($validation) > 0) {
            return (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            return (new Signin())->run($request);
        }
    }
}
