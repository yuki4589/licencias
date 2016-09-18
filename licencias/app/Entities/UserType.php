<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    /**
     * @todo add permissions
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
