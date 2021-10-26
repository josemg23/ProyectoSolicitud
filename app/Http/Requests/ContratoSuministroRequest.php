<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoSuministroRequest extends FormRequest
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
            'dependencia_id' => 'required',
            'departamento_id' => 'required',
            'total_neto' => 'required',
            'iva' => 'required',
            'total' => 'required',
            'cotizacion' => 'max:54000|mimes:jpg,jpeg,png,csv,txt,xlx,xls,docx,pdf',

        ];
    }
    public function messages()
    {
        return [
            'dependencia_id.required' => 'No has seleccionado una dependencia',
            'departamento_id.required' => 'No has seleccionado el departamento',
            'total_neto.required' => 'Falta el total Neto',
            'iva.required' => 'Falta el IVA',
            'total.required' => 'Falta el Total',
            'cotizacion.max' => 'El tamaño del archivo supera al permitido por el sistema',
            'cotizacion.mimes' => 'Solo puedes cargar archivos de tipo: jpg, jpeg, png, csv, txt, xlx, xls, docx, pdf.',
        ];
    }
    public function attributes()
    {
        return [
            "cotizacion" => "Cotizacion"
        ];
    }
}
