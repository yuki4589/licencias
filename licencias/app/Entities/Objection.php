<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_current_stage_id',
        'license_id',
        'license_stage_id',
        'first_person_position_id',
        'second_person_position_id',
        'report_date',
        'correction_date',
        'file_id',
    ];

    /**
     * An Objection belongs to License Current Stage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseCurrentStage()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseCurrentStage');
    }
    
    /**
     * An Objection belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * An Objection belongs to LicenseCurrentStage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseStage()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseCurrentStage');
    }

    /**
     * An Objection belongs to First Person Position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firstPersonPosition()
    {
        return $this->belongsTo('CityBoard\Entities\PersonPosition');
    }

    /**
     * An Objection belongs to Second Person Position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secondPersonPosition()
    {
        return $this->belongsTo('CityBoard\Entities\PersonPosition');
    }

    /**
     * An Objection has many Objection Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objectionNotifications()
    {
        return $this->hasMany('CityBoard\Entities\ObjectionNotification');
    }

    /**
     * An Objection has one File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('CityBoard\Entities\File');
    }

    /**
     * report_date_output
     *
     * @return bool|string
     */
    public function getReportDateOutputAttribute()
    {
        if (is_null($this->report_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->report_date));
    }

    /**
     * correction_date_output
     *
     * @return bool|string
     */
    public function getCorrectionDateOutputAttribute()
    {
        if (is_null($this->correction_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->correction_date));
    }

    /**
     * close
     *
     * @return bool
     */
    public function getCloseAttribute()
    {
        if(is_null($this->correction_date)) return false;

        return true;
    }
}
