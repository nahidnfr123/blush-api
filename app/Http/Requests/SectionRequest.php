<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'view_more_url' => 'nullable|string|max:255',
            'api_url' => 'nullable|string|max:255',
            'class_name' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'autoplay' => 'sometimes|required|boolean',
            'active' => 'sometimes|required|boolean',
            'order' => 'sometimes|required|integer',
        ];
    }
}
