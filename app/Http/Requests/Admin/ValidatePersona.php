<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePersona extends FormRequest
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
            /* 'dni' => 'nullable|min:8 | unique:persona,dni,' . $this->route('id'),
            'ruc' => 'nullable|min:12|numeric | unique:persona,ruc,' . $this->route('id'), */
            'nombres' => 'required |max:20',
            'apellidos' => 'max:20',
        ];
    }
}
