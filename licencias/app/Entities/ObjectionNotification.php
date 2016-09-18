<?php

namespace CityBoard\Entities;

use Illuminate\Database\Eloquent\Model;

class ObjectionNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'objection_id',
        'time_limit_id',
        'notification_date',
        'finish_date',
    ];

    /**
     * An ObjectionNotification belongs to Objection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objection()
    {
        return $this->belongsTo('CityBoard\Entities\Objection');
    }

    /**
     * An ObjectionNotification has one TimeLimit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeLimit()
    {
        return $this->belongsTo('CityBoard\Entities\TimeLimit');
    }

    /**
     * notification_date_output
     *
     * @return bool|string
     */
    public function getNotificationDateOutputAttribute()
    {
        if (is_null($this->notification_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->notification_date));
    }

    /**
     * finish_date_output
     *
     * @return bool|string
     */
    public function getFinishDateOutputAttribute()
    {
        if (is_null($this->finish_date)) {
            return "";
        }

        return date('d-m-Y', strtotime($this->finish_date));
    }
}
