<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sortBy' => 'nullable|string|max:100',
            'desc' => 'nullable|boolean',
            'limit' => 'nullable|integer|min:1|max:1000', // Adjust min and max values as needed
            'page' => 'nullable|integer|min:1|max:1000',
        ];
    }
}
