<?php

namespace App\Http\Requests;

use App\Rules\Rut;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class GetByRutRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], Response::HTTP_BAD_REQUEST)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rut' => [new Rut()]
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        if ($this->route('rut')) {
            $data['rut'] = strtoupper($this->route('rut'));
        }
        if (is_string($data['rut'])) {
            $data['rut'] = strtoupper($data['rut']);
        }
        return $data;
    }
}
