<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XmlRequest extends FormRequest
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
            'xml' => 'required|mimes:xml'

        ];
    }
    public function messages()
    {
        return [
            'xml.mimes' => 'El documento no es un archivo xml',

        ];
    }
}
