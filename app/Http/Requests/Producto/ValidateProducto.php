<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProducto extends FormRequest
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
            'nombre' => 'required | max:200 | unique:producto,nombre,' . $this->route('id'),
            'precioventa' => 'required',
            // 'preciocompra' => 'required',
            'categoria_id' => 'required',
            'unidad_id' => 'required',
        ];
    }
}