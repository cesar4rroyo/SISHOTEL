<?php

namespace App\Http\Requests;

use App\Models\Persona;
use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class PersonaRequest extends FormRequest
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
            'documento' => 'required|numeric',
            'nombres' => 'required|string|max:200',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (strlen($this->documento) == 8) {
                $tipodoc = 'dni';
                $name = 'nombres';
            } else {
                $tipodoc = 'ruc';
                $name = 'razonsocial';
            }
            if($this->id){
                $persona = Persona::where($tipodoc, $this->documento)->where('id', '!=', $this->id)->first();
            }else{
                $persona = Persona::where($tipodoc, $this->documento)->first();
            }
            if ($persona) {
                $validator->errors()->add('documento', 'El Nro. de Documento ya existe en la Base de Datos');
            }

            $this->merge(
                [ 
                    $tipodoc => $this->documento,
                    $name => $this->nombres,
                    'nacionalidad_id' => 155
                ]
            );

        });
    }

    public function messages()
    {
        return [
            'documento.required' => 'El Nro. de Documento es obligatorio',
            'documento.numeric' => 'El Nro. de Documento debe ser numerico',
            'nombres.required' => 'El campo nombres es obligatorio',
            'nombres.string' => 'El campo nombres debe ser una cadena de texto',
            'nombres.max' => 'El campo nombres debe tener maximo 200 caracteres',
        ];
    }

    public function filters()
    {
        return [
            'nombres' => 'uppercase',
            'direccion'=>'uppercase',
        ];
    }
}
