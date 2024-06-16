<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'title_bn' => 'sometimes|required|string|max:255',
            'sub_title' => 'sometimes|required|string|max:255',
            'sub_title_bn' => 'sometimes|required|string|max:255',
            'image' => 'required|image',
            'button_text' => 'sometimes|required|string|max:255',
            'button_text_bn' => 'sometimes|required|string|max:255',
            'button_link' => 'sometimes|required|string|max:255',
            'order' => 'sometimes|required|integer',
            'active' => 'required|boolean',
        ];
    }
}
