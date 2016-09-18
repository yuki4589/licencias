<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class UpdateLicenseCurrentStageRequest extends Request
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
            'license_stage_id' => 'required',
//            'date' => 'sometimes|required',
//            'person_id' => 'sometimes|required',
//            'number' => 'sometimes|required',
//            'file_id' => 'sometimes|required',
//            'stageObjection.first_person_position_id' => 'sometimes|required',
        ];
    }
}
