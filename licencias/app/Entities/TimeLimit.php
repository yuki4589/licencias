<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class TimeLimit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['weight', 'days', 'name', 'code'];
}
