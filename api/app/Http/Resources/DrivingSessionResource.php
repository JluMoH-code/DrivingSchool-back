<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Openapi\Attributes as OA;

#[OA\Schema(
    properties: [
        'id' => new OA\Property(property: 'id', type: 'integer', example: '1'),
        'score' => new OA\Property(property: 'score', type:'integer', example: '5'),
        'status' => new OA\Property(property: 'status', ref: '#components/schemas/SlotStatus'),
        'slot_id' => new OA\Property(property: 'slot_id', type: 'integer', example: '1'),
        'student_id' => new OA\Property(property: 'student_id', type: 'integer', example: '1'),
    ]
)]
class DrivingSessionResource extends JsonResource
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
            'score' => $this->score,
            'status' => $this->status,
            'slot_id' => $this->slot_id,
            'student_id' => $this->student_id,
        ];
    }
}
