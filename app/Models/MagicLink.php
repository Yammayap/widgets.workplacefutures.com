<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property CarbonImmutable $requested_at
 * @property CarbonImmutable $expires_at
 * @property CarbonImmutable|null $authenticated_at
 * @property string $ip_requested_from
 * @property string|null $ip_authenticated_from
 * @property string|null $intended_url
 *
 * @property-read User|null $user
 * @property-read string $signedUrl
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
        'requested_at' => 'immutable_date',
        'expires_at' => 'immutable_datetime',
        'authenticated_at' => 'immutable_datetime',
    ];

    public $timestamps = false;

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hasExpired(): bool
    {
        return $this->expires_at->isPast() && $this->authenticated_at == null;
    }

    /**
     * @return Attribute<string, never>
     */
    public function signedUrl(): Attribute
    {
        return new Attribute(
            get: fn() => URL::signedRoute('web.auth.magic-link', $this)
        );
    }

    /**
     * @param string|null $ipAddress
     * @return bool
     */
    public function isValid(string|null $ipAddress): bool
    {
        return $this->expires_at->isFuture()
            && $this->authenticated_at == null
            && $ipAddress == $this->ip_requested_from;
    }

    /**
     * @return string
     */
    public function getIntendedUrl(): string
    {
        if ($this->intended_url != null) {
            return $this->intended_url;
        }

        return route('web.home.index');
    }
}
