<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class StoreObjectionRequest extends Request
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
            'license_id' => 'required',
            'first_person_position_id' => 'required',
            'report_date' => 'required',
        ];
    }
}
