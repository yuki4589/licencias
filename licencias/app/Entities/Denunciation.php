<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Denunciation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['license_id', 'register_date', 'expedient_number', 'file_id', 'reason', 'status'];

    /**
     * A Denunciation belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * A Denunciation belongs to a File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('CityBoard\Entities\File');
    }

    /**
     * register_date_output
     *
     * @return bool|string
     */
    public function getRegisterDateOutputAttribute()
    {
        if (is_null($this->register_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->register_date));
    }
}
