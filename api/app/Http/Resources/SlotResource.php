<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Openapi\Attributes as OA;

#[OA\Schema(
    properties: [
        'id' => new OA\Property(property: 'id', type: 'integer', example: '1'),
        'start_time' => new OA\Property(property:'start_time', type:'datetime', example:'2025-01-01 21:00:00'),
        'status' => new OA\Property(property: 'status', ref: '#/components/schemas/SlotStatus'),
        'instructor' => new OA\Property(property: 'instructor', ref: '#/components/schemas/InstructorResource'),
        'car' => new OA\Property(property: 'car', ref: '#/components/schemas/CarResource'),
    ]
)]
class SlotResource extends JsonResource
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
            'start_time' => $this->start_time,
            'status' => $this->status,
            'instructor' => new InstructorResource($this->instructor),
            'car' => new CarResource($this->car),
        ];
    }
}
