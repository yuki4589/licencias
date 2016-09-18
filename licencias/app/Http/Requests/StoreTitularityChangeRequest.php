<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class StoreTitularityChangeRequest extends Request
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
            'expedient_number' => 'required',
            'register_number' => 'required',
            'register_date' => 'required',
        ];
    }
}
