<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'available_only' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', Rule::in(UserRole::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('available_only')) {
            $this->merge([
                'available_only' => filter_var($this->available_only, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        if ($this->has('roles') && is_string($this->roles)) {
            $this->merge([
                'roles' => explode(',', $this->roles)
            ]);
        }
    }
}
