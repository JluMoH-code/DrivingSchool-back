<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        'email' => new OA\Property(property: 'pernumber', type: 'string', example: '100000000'),
        'password' => new OA\Property(property: 'password', type: 'string', example: 'password'),
    ]
)]
class AuthRequest extends FormRequest
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
            'pernumber' => ['required', 'string', 'size:9'],
            'password' => ['required', 'string'],
        ];
    }
}
