<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'person_position_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
      'label',
    ];

    /**
     * A Person belongs to PersonPosition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personPosition()
    {
        return $this->belongsTo('CityBoard\Entities\PersonPosition');
    }

    /**
     * full_name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * label
     * @return string
     */
    public function getLabelAttribute()
    {
        return $this->id . " ". $this->first_name . " " . $this->last_name . " " . $this->personPosition->name;
    }

}
