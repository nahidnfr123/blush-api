<?php

namespace App\Http\Requests\Settings;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
      return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('update system setting');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'site_name' => 'required|string|max:255',
      'site_keywords' => 'nullable|string|max:255',
      'site_description' => 'nullable|string',
      'site_email' => 'nullable|email',
      'site_phone' => 'nullable|string|max:15',
      'site_address' => 'nullable|string|max:255',

      'site_logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'site_favicon' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512',

      'facebook_url' => 'nullable|url',
      'twitter_url' => 'nullable|url',
      'linkedin_url' => 'nullable|url',
      'youtube_url' => 'nullable|url',
      'instagram_url' => 'nullable|url',
      'whatsapp_url' => 'nullable|url',
    ];
  }
}
