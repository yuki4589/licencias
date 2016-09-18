<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class StoreObjectionNotificationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'objection_id' => 'required',
            'time_limit_id' => 'required',
            'notification_date' => 'required',
            'finish_date' => 'required',
        ];
    }
}
