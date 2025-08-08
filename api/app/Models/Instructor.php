<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string|null $bio
 * @property int|null $experience
 * @property float|null $rating
 * @property bool $is_active
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slot> $slots
 * @property-read int|null $slots_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\InstructorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instructor whereUserId($value)
 * @mixin \Eloquent
 */
class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'bio',
        'experience',
        'rating',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activeCar(): ?Car
    {
        return $this->cars()->where('is_active', true)->first();
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
