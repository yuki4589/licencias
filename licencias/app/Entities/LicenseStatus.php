<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class LicenseStatus extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'initial' => 'boolean',
      'reopen' => 'boolean',
      'reject' => 'boolean',
      'success' => 'boolean',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'initial',
      'reopen',
      'reject',
      'success'
    ];
}
