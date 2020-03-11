<?php


namespace App\Features;

use Illuminate\Http\Request;

class SigninFeature
{
    public function run(Request $request)
    {
        return (new SigninFeature())->run($request);
    }
}
