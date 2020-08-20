<?php

namespace App\Http\Controllers;

//use App\Calculation;
use App\php;
use App\Job;
use App\Product;
use App\Calculation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class ProductController extends ApiController
{
    public function show(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->api()->errorNotFound('Calculator not found');
        }

        $calc = $this->findCalculator($id);
        if (!$calc) {
            return response()->api()->errorNotFound('Calculator not found');
        }

        try {
            $product = Product::find($id);
        } catch (ModelNotFoundException $e) {
            return response()->api()->errorNotFound('Model search not found');
        }
        return response()->json($product);
    }

    public function addProduct(Request $request, $id) {
        $calcId = $request->input('calculator_id');
        $calculator = $this->findCalculator($calcId);
     
        if (!$calculator) {
            return response()->api()->errorNotFound('Calculator not found');
        }

        $user = \Auth::user();
        
        if (!$job = Job::find($request->input('job_id'))) {
            $job = Job::create(['name' => 'Unnamed Job']);
            $job->save();

            $user->jobs()->save($job);
            $job->setActiveJob();
        }

        $calcClass = $calculator['model'];
        if(!$calcClass) {
            return response()->api()->errorNotFound('Calculator model not found');
        }

        $calcClass = "App\\".$calcClass;
        if (!class_exists($calcClass)) {
            return response()->api()->errorNotFound('Model class not found');
        }

        try {
            $model = $calcClass::where('calculator_id', $calcId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->api()->errorNotFound('Model search not found');
        }
        // var_dump($model);
        try {
            $product = Product::where('product_code', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $product = Product::create();
            $product->update($request->all());
        }

        $model->product()->associate($product);
        $model->save();
 
        return response('Success');
    }

    private function findCalculator($id)
    {
        $return = false;
        $categories = \Config::get('categories.list');
        foreach ($categories as $category) {
            if ($calculators = $category['calculators']) {
                foreach ($calculators as $calculator) {
                    if ($calculator['id'] == $id) {
                        $return = $calculator;
                        break;
                    }
                }
            }
        }
        return $return;
    }
}
