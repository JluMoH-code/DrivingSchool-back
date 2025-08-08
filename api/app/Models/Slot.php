<?php

namespace App\Models;

use App\Enums\SlotStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $start_time
 * @property SlotStatus $status
 * @property int $instructor_id
 * @property int $car_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Car|null $car
 * @property-read \App\Models\DrivingSession|null $drivingSession
 * @property-read \App\Models\Instructor|null $instructor
 * @method static \Database\Factories\SlotFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'status' => SlotStatus::class,
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function drivingSession(): HasOne
    {
        return $this->hasOne(DrivingSession::class);
    }
}
