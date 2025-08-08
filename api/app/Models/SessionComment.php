<?php

namespace App\Models;

use App\Enums\SessionCommentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $content
 * @property SessionCommentType $type
 * @property int $driving_session_id
 * @property int $user_id
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\DrivingSession|null $drivingSession
 * @property-read SessionComment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SessionComment> $replies
 * @property-read int|null $replies_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereDrivingSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionComment whereUserId($value)
 * @mixin \Eloquent
 */
class SessionComment extends Model
{


    protected $fillable = [
        'content',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => SessionCommentType::class,
        ];
    }

    public function drivingSession(): BelongsTo
    {
        return $this->belongsTo(DrivingSession::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SessionComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(SessionComment::class, 'parent_id');
    }
}
