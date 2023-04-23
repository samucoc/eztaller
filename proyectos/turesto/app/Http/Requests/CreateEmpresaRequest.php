<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmpresaRequest extends FormRequest
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
            'empresa_rut'   => 'required',
            'empresa_nombre'    => 'required|string',
            'empresa_mutual'    => 'required|numeric'
        ];
    }
}
