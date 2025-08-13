<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Openapi\Attributes as OA;

#[OA\Schema(
    properties: [
        'id' => new OA\Property(property: 'id', type: 'integer', example: '1'),
        'bio' => new OA\Property(property: 'bio', type:'string', example: 'О себе'),
        'experience' => new OA\Property(property: 'experience', type: 'integer', example: 1),
        'rating' => new OA\Property(property: 'rating', type: 'float', example: 3.0),
    ]
)]
class InstructorSlotResource extends JsonResource
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
            'bio' => $this->bio,
            'experience' => $this->experience,
            'rating' => $this->rating,
        ];
    }
}
