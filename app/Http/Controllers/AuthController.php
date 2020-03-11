<?php


namespace App\Http\Controllers;

use App\Features\SigninFeature;
use App\Features\SignupFeature;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function signup()
    {
        return (new SignupFeature())->run($this->request);
    }

    public function signin()
    {
        return (new SigninFeature())->run($this->request);
    }
}
