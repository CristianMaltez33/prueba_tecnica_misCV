<?php

namespace App\Http\Requests\MisCv;

use Illuminate\Foundation\Http\FormRequest;

class SearchCvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'facademica_estado' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'facademica_especialidad' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'departamento' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'licencia' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'vehiculo' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'salario' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }
}
