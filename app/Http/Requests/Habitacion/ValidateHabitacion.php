<?php

namespace App\Http\Requests\Habitacion;

use Illuminate\Foundation\Http\FormRequest;

class ValidateHabitacion extends FormRequest
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
            'numero' => 'required | unique:habitacion,numero,' . $this->route('id'),
            'situacion' => 'required |max:200',
            'precio' => 'required',
            'piso' => 'required',
            'tipohabitacion' => 'required'
        ];
    }
}
