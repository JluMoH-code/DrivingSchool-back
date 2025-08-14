<?php

namespace App\Http\Requests;

use App\Enums\Transmission;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SlotsListRequest extends FormRequest
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
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
            'from_time' => ['nullable', 'date_format:H:i'],
            'to_time' => ['nullable', 'date_format:H:i', 'after_or_equal:from_time'],
            'instructor_ids' => ['nullable', 'array'],
            'instructor_ids.*' => ['integer'],
            'car_ids' => ['nullable', 'array'],
            'car_ids.*' => ['integer'],
            'transmissions' => ['nullable', 'array'],
            'transmissions.*' => ['string', Rule::in(Transmission::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('available_only')) {
            $this->merge([
                'available_only' => filter_var($this->available_only, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        if ($this->has('instructor_ids') && is_string($this->instructor_ids)) {
            $this->merge([
                'instructor_ids' => array_map('intval', explode(',', $this->instructor_ids))
            ]);
        }

        if ($this->has('car_ids') && is_string($this->car_ids)) {
            $this->merge([
                'car_ids' => array_map('intval', explode(',', $this->car_ids))
            ]);
        }

        if ($this->has('transmissions') && is_string($this->transmissions)) {
            $this->merge([
                'transmissions' => explode(',', $this->transmissions)
            ]);
        }
    }
}
