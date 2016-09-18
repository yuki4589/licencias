<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class UpdateLicenseRequest extends Request
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
            'license_type_id' => 'required',
            'expedient_number' => 'required',
            'register_date' => 'required',
            'register_number' => 'required',
            'street_number' => 'required',
            'postcode' => 'required | numeric',
            'city' => 'required',
        ];
    }
}
