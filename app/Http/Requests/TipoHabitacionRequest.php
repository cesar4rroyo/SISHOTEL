<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class TipoHabitacionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100|unique:tipohabitacion,nombre,'.$this->id .',id',
            'precio'=> 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres',
            'nombre.max' => 'El nombre debe tener máximo 100 caracteres',
            'nombre.unique' => 'El nombre ya existe',
            'precio.required' => 'El precio es requerido',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio debe ser mayor o igual a 0',
        ];
    }

    public function filters()
    {
        return [
            'nombre' => 'trim|escape|capitalize',
            'precio' => 'trim|escape',
        ];
    }   
}
