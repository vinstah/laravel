<?php

namespace App\Http\Controllers;

use App\Calculation;
use App\Job;
use Illuminate\Http\Request;

class SummaryController extends ApiController
{

    public function show(Job $job)
    {
        /*$user = \Auth::user();
        $job = Job::find($user->active_job);*/
        return response()->json($job->calculations()->getResults());
    }

    public function update(Request $request, Calculation $calculation)
    {

        if(!$request->input('product_id')) {
            return $this->response->errorWrongArgs('Product id must be specified');
        }

        //@todo: check product exists

        $productId = $request->input('product_id');
        $calculation->update(['product_id' => $productId]);

        return response()->json(['success' => 1]);

        /*$job->products()->attach($productId);
        return $job->products()->getResults();*/
    }

}
