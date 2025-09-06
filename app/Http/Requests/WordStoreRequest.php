<?php

namespace App\Http\Requests;

use App\DTO\Admin\WordStoreDTO;
use Illuminate\Foundation\Http\FormRequest;

class WordStoreRequest extends FormRequest
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
            'word' => 'required|string',
            'stress' => '',
            'description' => 'required|string',
            'sentence' => '',
        ];
    }

    public function toDTO()
    {
        return WordStoreDTO::fromArray($this->validated());
    }
}
