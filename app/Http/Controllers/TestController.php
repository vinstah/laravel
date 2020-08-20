<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends ApiController
{

    public function error403()
    {
        return response()->json('This is a 403 error', 403);
    }

    public function error500()
    {
        return response()->json('This is a 500 error', 500);
    }

    public function errorValidation()
    {
        return response()->api()->errorWrongArgs(['This thing isn\'t valid']);
    }

}
