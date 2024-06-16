<?php

namespace App\Http\Requests\Tag;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('create tag');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name',
            'name_bn' => 'sometimes|required|string|max:255|unique:tags,name_bn',
        ];
    }
}
