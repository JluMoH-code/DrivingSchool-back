<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        'id' => new OA\Property(property: 'id', type: 'integer', example: '1'),
        'pernumber' => new OA\Property(property:'pernumber', type:'number', example: '100000000'),
        'phone' => new OA\Property(property: 'phone', type: 'number', example: '79999999999'),
        'name' => new OA\Property(property: 'name', type: 'string', example: 'Иванов Иван'),
        'role' => new OA\Property(property: 'role', type: 'string', example: 'student'),
        'is_active' => new OA\Property(property: 'is_active', type: 'boolean', example: true),
    ]
)]
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pernumber' => $this->pernumber,
            'phone' => $this->phone,
            'name' => $this->name,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ];
    }
}
