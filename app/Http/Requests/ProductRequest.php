<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class ProductRequest extends LaravelFormRequest
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
            'nombre' => 'required |max:255 | unique:producto,nombre, '.$this->id.',id',
            'precioventa' => 'required|numeric|min:0',
            'categoria_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre debe tener menos de 100 caracteres',
            'nombre.unique' => 'El nombre ya existe',
            'precioventa.required' => 'El precio de venta es requerido',
            'precioventa.numeric' => 'El precio de venta debe ser un número',
            'categoria_id.required' => 'La categoria es requerida',
        ];
    }

}   
