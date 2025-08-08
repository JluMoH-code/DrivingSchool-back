<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Openapi\Attributes as OA;

#[OA\Schema(
    properties: [
        'id' => new OA\Property(property: 'id', type: 'integer', example: '1'),
        'brand' => new OA\Property(property:'brand', type:'string', example:'Lada'),
        'model' => new OA\Property(property: 'model', type: 'string', example: 'Kalina'),
        'color' => new OA\Property(property: 'color', type: 'string', example: 'Портвейн'),
        'state_number' => new OA\Property(property: 'state_number', type: 'string', example: 'А100А099'),
        'transmission' => new OA\Property(property: 'transmission', ref: '#/components/schemas/Transmission'),
        'is_active' => new OA\Property(property: 'is_active', type: 'boolean', example: true),
        'instructor_id' => new OA\Property(property: 'instructor_id', type: 'integer', example: 1),
    ]
)]
class CarResource extends JsonResource
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
            'brand' => $this->brand,
            'model' => $this->model,
            'color' => $this->color,
            'state_number' => $this->state_number,
            'transmission' => $this->transmission,
            'is_active' => $this->is_active,
            'instructor_id' => $this->instructor->id,
        ];
    }
}
