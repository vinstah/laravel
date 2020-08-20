<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenusController extends ApiController
{
    public function index()
    {
        $menus = [
            [
                "id" => 1,
                "title" => "",
                "items" => [
                    [
                        "id" => 1,
                        "title" => "Dashboard",
                        "type" => "dashboard"
                    ],
                    [
                        "id" => 2,
                        "title" => "Your Jobs",
                        "notifications" => "4",
                        "type" => "jobs"
                    ]
                ]
            ],
            [
                "id" => 2,
                "title" => "Calculators",
                "items" => [
                    [
                        "id" => 1,
                        "title" => "Lintels",
                        "type" => "category"
                    ],
                    [
                        "id" => 2,
                        "title" => "Roof Framing",
                        "type" => "category"
                    ],
                    [
                        "id" => 3,
                        "title" => "Floor Framing",
                        "type" => "category"
                    ],
                    [
                        "id" => 4,
                        "title" => "Post & Piles",
                        "type" => "category"
                    ]
                ]
            ]
        ];

        return response()->json($menus);
    }
}
