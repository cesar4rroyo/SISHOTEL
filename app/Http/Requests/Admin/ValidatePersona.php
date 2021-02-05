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
            'dni' => 'nullable|numeric|unique:persona,dni,' . $this->route('id'),
            'ruc' => 'nullable|numeric|unique:persona,ruc,' . $this->route('id'),
        ];
    }
}
