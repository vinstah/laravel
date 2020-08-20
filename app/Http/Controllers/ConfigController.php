<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;

class ConfigController extends ApiController
{

    /**
     * Return current base config for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = \Auth::user();

        if(!$user->exists()) {
            return false;
        }

        $currentJob = null;
        if($user->active_job) {
            if($job = Job::find($user->active_job)) {
                $job = $job->load('calculations');
                $currentJob = $job->toArray();
            }
        }

        $jobs = $user->jobs();

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
                        "notifications" => $jobs->count(),
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

        $categories = \Config::get('categories.list');

        $config = [
            "currentJob" => $currentJob,
            "menus" => $menus,
            "categories" => $categories
        ];

        return response()->json($config);
    }

}
