<?php

namespace App\Http\Requests;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class GridRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                ->can('create grid');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grid_id' => 'required',
            'title' => 'required|string|max:255',
            'class_name' => 'sometimes|string|max:255',
            'active' => 'sometimes|boolean',
            'items' => 'required|array',
            'items.*.id' => 'nullable|integer',
            'items.*.title' => 'nullable|string|max:255',
            'items.*.title_bn' => 'nullable|string|max:255',
            'items.*.subtitle' => 'nullable|string|max:255',
            'items.*.subtitle_bn' => 'nullable|string|max:255',
            'items.*.button_text' => 'nullable|string|max:255',
            'items.*.button_text_bn' => 'nullable|string|max:255',
            'items.*.url' => 'nullable|string|max:255',
            'items.*.image' => 'nullable|string', // link to image
            'items.*.class_name' => 'nullable|string|max:255',
            'items.*.height' => 'nullable|string|max:255',
            'items.*.order' => 'nullable|integer',
        ];
    }
}
