<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class LicenseCurrentStage extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'optional' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_id',
        'license_stage_id',
        'date',
        'person_id',
        'number',
        'file_id',
        'objection_id',
        'optional',
    ];

    /**
     * A LicenseCurrentStage belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * A LicenseCurrentStage has one LicenseStage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseStage()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseStage');
    }

    /**
     * A LicenseCurrentStage belongs to Person.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('CityBoard\Entities\Person');
    }

    /**
     * A LicenseCurrentStage has one File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('CityBoard\Entities\File');
    }

    /**
     * A LicenseCurrentStage has one Active Objection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objection()
    {
        return $this->belongsTo('CityBoard\Entities\Objection');
    }

    /**
     * A LicenseCurrentStage has many Objections.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objections()
    {
        return $this->hasMany('CityBoard\Entities\Objection');
    }
    
    /**
     * date_output
     *
     * @return bool|string
     */
    public function getDateOutputAttribute()
    {
        if (is_null($this->date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->date));
    }
}
