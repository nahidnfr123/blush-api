<?php

namespace App\Http\Requests\Settings;

use App\Enums\GuardEnums as Guard;
use Illuminate\Foundation\Http\FormRequest;

class SocialAuthSettingsRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
      return auth(Guard::Admin->value)->check() && auth(Guard::Admin->value)->user()->can('update social auth setting');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'provider' => ['required', 'unique:social_auth_settings,provider,' . $this->id],
      'client_id' => 'required',
      'client_secret' => 'required',
      'redirect_url' => 'required',
      'active' => 'sometimes|boolean',
      'logo' => ($this->id ? 'sometimes' : 'required') . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];
  }
}
