<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidacaoDataAluguel;

class StoreLivroUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void 
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $livroId = $this->route('livroId');

        return [
            'dt_aluguel_ini' => [
                'required',
                'date',
                'after_or_equal:now',
                new ValidacaoDataAluguel($livroId, $this->dt_aluguel_ini),
            ],
            'dt_aluguel_fim' => 'required|date|after:dt_aluguel_ini',
        ];
    }
}