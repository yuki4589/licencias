<?php

namespace CityBoard\Http\Requests;

use CityBoard\Http\Requests\Request;

class UpdateFileRequest extends Request
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
            'filename' => 'required',
            'mime_type' => 'required',
        ];
    }
}
