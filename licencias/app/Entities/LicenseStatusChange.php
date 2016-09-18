<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class LicenseStatusChange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['license_id', 'license_status_id', 'change_date'];

    /**
     * A LicenseStatusChange belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * A LicenseStatusChange belongs to License_status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licenseStatus()
    {
        return $this->belongsTo('CityBoard\Entities\LicenseStatus');
    }

    /**
     * change_date_output
     *
     * @return bool|string
     */
    public function getChangeDateOutputAttribute()
    {
        if (is_null($this->change_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->change_date));
    }
}
