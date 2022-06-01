<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class GrupoMenuRequest extends FormRequest
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
            'nombre' => 'required | max:100 | unique:grupomenu,nombre,' . $this->id . ',id',
            'orden'=>'numeric',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre debe tener menos de 100 caracteres',
            'nombre.unique' => 'El nombre ya existe',
            'orden.numeric' => 'El orden debe ser un número',
        ];
    }


    public function filters()
    {
        return [
            'nombre' => 'trim|escape|capitalize',
            'orden' => 'trim|escape',
        ];
    }
}
