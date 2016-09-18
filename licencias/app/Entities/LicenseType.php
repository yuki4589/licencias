<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class LicenseType extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'visit' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'visit'];

    /**
     * A LicenseType has many LicenseTypeStage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenseTypeStages()
    {
        return $this->hasMany('CityBoard\Entities\LicenseTypeStage');
    }
}
