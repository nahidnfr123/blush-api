<?php

namespace App\Http\Requests\VariantAttributes;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('update variant attribute');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:variant_attributes,name,' . $this->slug . ',slug',
            'slug' => 'required|string|max:255|unique:variant_attributes,slug,' . $this->slug . ',slug',
            'active' => 'required|boolean',
        ];
    }
}
