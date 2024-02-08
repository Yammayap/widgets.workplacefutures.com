<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property CarbonImmutable $requested_at
 * @property CarbonImmutable $expires_at
 * @property CarbonImmutable $authenticated_at
 * @property string $ip_requested_from
 * @property string|null $ip_authenticated_from
 * @property string $intended_url
 *
 * @property-read User|null $user
 */
class MagicLink extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'magic_links';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string|class-string>
     */
    protected $casts = [
        // todo: discuss - do we need to cast IP addresses?
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return bool
     */
    public function hasAuthenticated(): bool
    {
        return $this->authenticated_at->isPast();
    }

    public function hasExpired(): bool
    {
        return $this->expires_at->isPast() && $this->authenticated_at == null;
    }
}
