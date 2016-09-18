<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class StoreLicenseTypeStageRequest extends Request
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
            'license_stage_id' => 'required',
            'weight' => 'required',
            'license_generate' => 'required',
        ];
    }
}
