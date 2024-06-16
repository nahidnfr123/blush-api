<?php

namespace App\Http\Requests\Category;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                ->can('update category');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_bn' => 'sometimes|required|string|max:255',
            'icon' => 'nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'required|in:0,1',
//      'order' => 'required|integer',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'featured' => 'required|in:0,1',
        ];
    }
}
