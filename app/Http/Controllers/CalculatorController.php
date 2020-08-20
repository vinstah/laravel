<?php

namespace App\Http\Controllers;

//use App\Calculation;
use App\php;
use App\CalculatorAPI;
use App\SupportingRoofCalculation;
use App\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class CalculatorController extends ApiController
{
    public function show(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->api()->errorNotFound('Calculator not found');
        }

        $return = $this->findCalculator($id);
        if (!$return) {
            return response()->api()->errorNotFound('Calculator not found');
        }

        return response()->json($return);
    }

    public function calculate(Request $request, $id)
    {
        $calculator = $this->findCalculator($id);
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

        $api = new CalculatorAPI();
        $params = $request->all();

        $result = $api->getCalculation($calculator['url_segment'], $params);

        $calcClass = $calculator['model'];
        if(!$calcClass) {
            return response()->api()->errorNotFound('Calculator model not found');
        }

        $calcClass = "App\\".$calcClass;
        if (!class_exists($calcClass)) {
            return response()->api()->errorNotFound('Model class not found');
        }

        try {
            $model = $calcClass::where('calculator_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $model = $calcClass::create(['job_id' => $job->id]);
            $model->job_id = $job->id;
            $model->title = $calculator['title'];
            $model->calculator_id = $id;
        }

        $validator = $model->validate($params);
        if ($validator->fails()) {
            return response()->api()->errorWrongArgs($validator->errors());
        }
         
        $model->update($request->all());

        // $result = [];
        $result['calculation_id'] = $model->calculator_id;
        // $result = array_merge($result, $calculation);
        return response()->json($result);
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
