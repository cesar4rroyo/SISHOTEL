<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class OpcionMenuRequest extends FormRequest
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
            'nombre' => 'required | max:100',
            'link' => 'required |max:100',
            'orden'=>'numeric',
            'grupomenu_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre debe tener menos de 100 caracteres',
            'link.required' => 'El link es requerido',
            'link.max' => 'El link debe tener menos de 100 caracteres',
            'orden.numeric' => 'El orden debe ser un número',
            'grupomenu_id.required' => 'El grupo de menu es requerido',
        ];
    }


    public function filters()
    {
        return [
            'nombre' => 'trim|escape|capitalize',
            'orden' => 'trim|escape',
            'grupomenu_id' => 'trim|escape',
        ];
    }
}
