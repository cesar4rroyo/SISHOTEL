<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadRequest extends FormRequest
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
            'nombre' => 'required|string|max:50|unique:unidad, nombre, '.$this->id .', id',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres',
            'nombre.max' => 'El nombre debe tener máximo 50 caracteres',
            'nombre.unique' => 'El nombre ya existe',
        ];
    }
}
