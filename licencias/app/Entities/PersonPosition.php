<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class PersonPosition extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
  ];

}
