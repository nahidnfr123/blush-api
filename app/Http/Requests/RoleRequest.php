<?php

namespace App\Http\Requests;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (request()->isMethod('post')) {
            return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('create role');
        }
        if (request()->isMethod('put') || request()->isMethod('patch')) {
            return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('update role');
        }
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
            'name' => 'required|string|max:255|unique:roles,name',
        ];
    }
}
