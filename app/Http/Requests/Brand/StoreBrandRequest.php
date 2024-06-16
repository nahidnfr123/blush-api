<?php

namespace App\Http\Requests\Brand;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                ->can('create brand');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name',
            'name_bn' => 'sometimes|required|string|max:255|unique:brands,name_bn',
            'description' => 'nullable|string',
            'logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ];
    }
}
