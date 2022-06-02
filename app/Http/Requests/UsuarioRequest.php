<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class UsuarioRequest extends FormRequest
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
            'login' => 'required|string|max:50|unique:usuario,login,'.$this->id . ',id',
            'tipousuario_id' => 'required|integer|exists:tipousuario,id',
            'persona_id' => 'integer|exists:persona,id',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'El campo login es obligatorio',
            'login.string' => 'El campo login debe ser un texto',
            'login.max' => 'El campo login debe tener como máximo 50 caracteres',
            'login.unique' => 'El nombre de usuario ya existe',
            'tipousuario_id.required' => 'El campo tipo de usuario es obligatorio',
            'tipousuario_id.integer' => 'El campo tipo de usuario debe ser un número entero',
            'tipousuario_id.exists' => 'El tipo de usuario no existe',
            'persona_id.integer' => 'El campo persona debe ser un número entero',
            'persona_id.exists' => 'La persona no existe',
        ];
    }

    public function filters()
    {
        return [
            'login' => 'trim|escape',
            'tipousuario_id' => 'trim|escape',
            'persona_id' => 'trim|escape',
        ];
    }
}
