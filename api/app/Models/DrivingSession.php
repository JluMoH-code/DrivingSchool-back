<?php

namespace App\Models;

use App\Enums\DrivingSessionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $score
 * @property DrivingSessionStatus $status
 * @property int $slot_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SessionComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Slot|null $slot
 * @property-read \App\Models\User|null $student
 * @method static \Database\Factories\DrivingSessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DrivingSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DrivingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'status',
        'student_id',
        'slot_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => DrivingSessionStatus::class,
        ];
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(SessionComment::class);
    }
}
