<?php

namespace App\Http\Requests;

use App\Enums\GuardEnums as Guard;
use App\Enums\PageContentTypeEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()
                ->can('create page');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'sections' => 'required|array',
            'sections.*.title' => 'sometimes|required|string|max:255',
            'sections.*.title_bn' => 'sometimes|required|string|max:255',
            'sections.*.type' => ['required', 'string', Rule::enum(PageContentTypeEnums::class)],
            'sections.*.content' => 'sometimes|required|string',
            'sections.*.view_more_url' => 'sometimes|required|string',
            'sections.*.api_url' => 'sometimes|required|string',
            'sections.*.class_name' => 'sometimes|required|string',
            'sections.*.autoplay' => 'sometimes|required|boolean',
            'sections.*.active' => 'sometimes|required|boolean',
            'sections.*.order' => 'sometimes|required|integer',

        ];
    }
}
