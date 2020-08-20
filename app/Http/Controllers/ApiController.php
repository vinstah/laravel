<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;

class ApiController extends Controller
{

    /**
     * @param Response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
