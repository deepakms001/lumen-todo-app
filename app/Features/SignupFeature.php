<?php


namespace App\Features;

use App\Operations\Auth\Signup;
use App\Operations\Auth\ValidateSignup;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SignupFeature
{
    public function run(Request $request)
    {
        $validation = (new ValidateSignup())->run($request);
        if (count($validation) > 0) {
            $result = (new JsonResponse([
                'status' => 'failed',
                'message' => 'Please fill all mandatory fields properly.',
                'error' => $validation
            ], 422));
        } else {
            $user = (new Signup())->run($request->all());
            if (isset($user->id)) {
                $result = (new JsonResponse([
                    'status' => 'success',
                    'message' => 'You have registered successfully.',
                    'user' => $user
                ], 200));
            } else {
                throw new Exception('Unable to register.', 400);
            }
        }
        return $result;
    }
}
