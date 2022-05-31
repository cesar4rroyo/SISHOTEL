<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class HabitacionRequest extends FormRequest
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
            'numero' => 'required',
            'piso_id' => 'required',
            'tipohabitacion_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'El número de habitación es obligatorio',
            'piso_id.required' => 'El piso es obligatorio',
            'tipohabitacion_id.required' => 'El tipo de habitación es obligatorio',
        ];
    }

    public function filters()
    {
        return [
            'nombre' => 'trim|uppercase|escape',
        ];
    }
}
