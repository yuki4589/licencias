<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'place'];

    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->place;
    }
}
