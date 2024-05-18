<?php

namespace App\Http\Requests\Faction;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactionRequest extends FormRequest
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
            "name" => ["required", "string", "min:3"],
            "title" => ["required", "string", "min:3"],
            "description" => ["required", "string", "min:3"],
            "image" => ["required", "mimes:png,jpg,jpeg,webp", "max:5048"]
        ];
    }
}
