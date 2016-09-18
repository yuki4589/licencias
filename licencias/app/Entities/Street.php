<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
