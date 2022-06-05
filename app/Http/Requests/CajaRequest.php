<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CajaRequest extends FormRequest
{
    use SanitizesInput;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'usuario_id' => auth()->user()->id,
            'montoefectivo' => $this->total,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha' => 'required|date|date_format:Y-m-d H:i:s',
            'numero' => 'required',
            'tipo' => 'required|string',
            'concepto_id' => 'required|integer',
            'total' => 'required|numeric',
            'observacion' => 'string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'Debe ingresar una fecha',
            'fecha.date' => 'Debe ingresar una fecha válida',
            'fecha.date_format' => 'Debe ingresar una fecha válida',
            'numero.required' => 'Debe ingresar un número',
            'tipo.required' => 'Debe ingresar un tipo',
            'concepto_id.required' => 'Debe ingresar un concepto',
            'concepto_id.integer' => 'Debe ingresar un concepto válido',
            'total.required' => 'Debe ingresar un monto',
            'total.numeric' => 'Debe ingresar un monto válido',
            'observacion.string' => 'Debe ingresar una observación',
            'observacion.max' => 'Debe ingresar una observación con un máximo de 500 caracteres',
        ];
    }

    public function filters()
    {
        return [
            'fecha' => 'trim|escape',
            'numero' => 'trim|escape|capitalize',
            'tipo' => 'trim|escape|capitalize',
            'concepto_id' => 'trim',
            'monto' => 'trim',
            'observacion' => 'trim|escape|capitalize',
        ];
    }
}
