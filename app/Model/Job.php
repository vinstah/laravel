<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'job_number',
        'building_type',
        'rigidity_ratio',
        'capacity_ratio',
        'roof_weight',
        'custom_roof_weight',
        'roof_pitch',
        'eaves_width',
        'windzone',
        'wind_speed',
        'snow_region',
        'altitude'
    ];


    /**
     * Return owner of this job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Return calculations associated to this job
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calculations()
    {
        return $this->hasMany(Calculation::class);
    }

    /**
     * Set job as active job for loggedin user
     * @return bool
     */
    public function setActiveJob() {
        $user = \Auth::user();
        if($user->exists()) {
            $user->active_job = $this->id;
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * Overwrite base toArray function to change output names
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        return $array;
    }

}
