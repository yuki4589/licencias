<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class LicenseTypeStage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_type_id',
        'license_stage_id',
        'weight',
        'previous',
        'next',
        'license_generate',
    ];

    /**
     * A LicenseTypeStage belongs to LicenseType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseType()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseType');
    }

    /**
     * A LicenseTypeStage has one LicenseStage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseStage()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseStage');
    }
}
