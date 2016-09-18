<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['license_id', 'person_id', 'loan_date', 'giving_back_date'];

    /**
     * A Loan belongs to License.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license()
    {
        return $this->belongsTo('CityBoard\Entities\License');
    }

    /**
     * A Loan belongs to Person.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('CityBoard\Entities\Person');
    }

    /**
     * loan_date_output
     *
     * @return bool|string
     */
    public function getLoanDateOutputAttribute()
    {
        if (is_null($this->loan_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->loan_date));
    }

    /**
     * giving_back_date_output
     *
     * @return bool|string
     */
    public function getGivingBackDateOutputAttribute()
    {
        if (is_null($this->giving_back_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->giving_back_date));
    }
}
