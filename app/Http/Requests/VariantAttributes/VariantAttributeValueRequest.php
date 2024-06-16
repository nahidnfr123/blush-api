<?php

namespace App\Http\Requests\VariantAttributes;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class VariantAttributeValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (request()->isMethod('put') || request()->isMethod('patch')) {
            return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                    ->can('update variant attribute value');
        } else {
            return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                    ->can('create variant attribute value');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'variant_attribute_id' => 'required|exists:variant_attributes,id',
            'value' => 'required|string',
            'slug' => 'required|string|unique:variant_attribute_values,slug,' . $this->slug . ',slug',
        ];
    }
}
