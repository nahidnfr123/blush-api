<?php

namespace App\Http\Requests;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('update profile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => 'sometimes|nullable|string|max:255|unique:admins,mobile,' . $this->admin->id,
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trash_mode' => 'sometimes|nullable|boolean',
            'always_update_apis' => 'sometimes|nullable|boolean',
            'simple_breadcrumb' => 'sometimes|nullable|boolean',
        ];
    }
}
