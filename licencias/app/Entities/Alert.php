<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;


class Alert extends Model
{
    //
    protected $fillable = [
    	'title',
    	'date',
    	'description',
    	'license_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * A LicenseStatusChange belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }
}
