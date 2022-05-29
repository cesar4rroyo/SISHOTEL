<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConceptoRequest extends FormRequest
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
            'nombre' => 'required | max:100 | unique:concepto,nombre,' . $this->id . ',id',
            'tipo' => 'required |max:100'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre debe tener menos de 100 caracteres',
            'nombre.unique' => 'El nombre ya existe',
            'tipo.required' => 'El tipo es requerido',
            'tipo.max' => 'El tipo debe tener menos de 100 caracteres'
        ];
    }
}
