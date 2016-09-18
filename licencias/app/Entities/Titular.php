<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Titular extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nif', 'first_name', 'last_name', 'phone_number', 'email'];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getNifFullNameAttribute()
    {
        return $this->nif . " " . $this->full_name;
    }
}
