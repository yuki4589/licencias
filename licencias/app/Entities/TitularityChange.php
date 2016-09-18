<?php

namespace CityBoard\Entities;

use CityBoard\Repositories\TitularityChangeRepository;
use Illuminate\Database\Eloquent\Model;

class TitularityChange extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'finished' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_id',
        'titular_id',
        'expedient_number',
        'register_number',
        'register_date',
        'finished',
        'finished_date',
        'status',
        'file_id',
    ];

    /**
     * A TitularityChange belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * A TitularityChange belongs to Titular.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function titular()
    {
        return $this->belongsTo('CityBoard\Entities\Titular');
    }

    /**
     * A TitularityChange belongs to File.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('CityBoard\Entities\File');
    }

    public function getRegisterDateOutputAttribute()
    {
        if (is_null($this->register_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->register_date));
    }

    public function getFinishedDateOutputAttribute()
    {
        if (is_null($this->finished_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->finished_date));
    }

    /**
     * titular_nif
     *
     * @return integer
     */
    public function getTitularNifAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->nif;
    }

    /**
     * titular_first_name
     *
     * @return integer
     */
    public function getTitularFirstNameAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->first_name;
    }

    /**
     * titular_first_name
     *
     * @return integer
     */
    public function getTitularLastNameAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->last_name;
    }

    /**
     * titular_phone_number
     *
     * @return integer
     */
    public function getTitularPhoneNumberAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->phone_number;
    }

    /**
     * titular_phone_number
     *
     * @return integer
     */
    public function getTitularEmailAttribute()
    {
        if (is_null($this->titular)) return null;

        return $this->titular->email;
    }

    /**
     * open
     *
     * @return integer
     */
    public function getOpenAttribute()
    {
        if ($this->status == 'Solicitado') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * last_titular
     *
     * @return integer
     */
    public function getLastTitularAttribute()
    {
        $titularityChangeRepository = new TitularityChangeRepository();
       return $titularityChangeRepository->lastTitular($this);
    }
}
