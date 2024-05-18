<?php

namespace App\Http\Requests\Classes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetClassesRequest extends FormRequest
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
            "search" => ["string"],
            "order" => [Rule::in(["title", "name", "description", "created_at", "updated_at"])],
            "direction" => [Rule::in(["asc", "desc"])],
            "perPage" => ["numeric"],
            "page" => ["numeric"]
        ];
    }
}
