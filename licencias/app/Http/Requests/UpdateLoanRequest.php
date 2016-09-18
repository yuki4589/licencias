<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class UpdateLoanRequest extends Request
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
            'person_id' => 'required',
            'loan_date' => 'required',
            'giving_back_date' => 'required',
        ];
    }
}
