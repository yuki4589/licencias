<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeAlert extends Model
{
    //
    protected $fillable = [
    	'id',
    	'type',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * A LicenseStatusChange hasMany to Alert.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alert()
    {
        return $this->hasMany('CityBoard\Entities\Alert');
    }
}
