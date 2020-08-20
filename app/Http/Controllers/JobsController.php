<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;

class JobsController extends ApiController
{

    public function index()
    {
        $user = \Auth::user();
        if($user->exists()) {
            return $user->jobs()->with('Calculations')->getResults();
        }

        //return Job::all();
    }

    public function show(Job $job)
    {
        /**
         * Set this as the active job
         */
        $job->setActiveJob();

        if(\Request::input('calculations')) {
            $job->load('calculations');
        }

        return response()->json($job);
    }

    public function store(Request $request)
    {
        $job = Job::create($request->all());

        $user = \Auth::user();
        if($user->exists()) {
            $user->jobs()->save($job);
            return response()->json($job, 201);
        }

        return response()->json([], 403);
    }

    public function update(Request $request, Job $job)
    {
        $job->update($request->all());

        //@todo confirm user owns the job

        return response()->json($job, 200);
    }

    public function delete(Job $job)
    {
        $job->delete();

        //@todo confirm user owns the job

        //@todo if job is active, unset active job id

        return response()->json(null, 204);
    }

}
