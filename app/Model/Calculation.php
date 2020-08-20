<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Calculation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'product_id',
        'calculator_id',
        'title',
        'altitude',
        'atticfloorload',
        'atticfloorwidth',
        'building_type',
        'capacity_ratio',
        'ceiling',
        'custom_roof_weight',
        'description',
        'eaves_width',
        'exposed',
        'finish',
        'floor_live_load',
        'ground_snow',
        'include_lvl',
        'lintel_span',
        'obstructed_roof',
        'rigidity_ratio',
        'roof_pitch',
        'roof_span_r',
        'roof_weight',
        'sguls',
        'sgsls',
        'size',
        'snow',
        'snow_region',
        'suls',
        'ssls',
        'supported_floor_span_f',
        'wall_height_h',
        'timber',
        'treatment',
        'visual',
        'wall_height_h',
        'wind_speed',
        'wind_zone'
    ];

    /**
     * Validation rules, set on child model
     * @var array
     */
    public $rules = [];

    /**
     * Return job associated to this calculation

     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Return product associated to this calculation

     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    /**
     * Validate data from rules
     *
     * @param $data
     * @return mixed
     */
    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules);
        return $validator;
    }

    /**
     * Run the calculation
     * Function to be overwritten by child calculator
     * @param $params
     * @return bool
     */
    public function calculate($params) {
        return false;
    }
}
