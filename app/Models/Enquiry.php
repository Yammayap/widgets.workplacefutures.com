<?php

namespace App\Models;

use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Traits\HasUuid;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $uuid
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property int $user_id
 * @property Tenant $tenant
 * @property Widget $widget
 * @property string $message
 * @property boolean $can_contact
 */
class Enquiry extends Authenticatable
{
    use HasFactory;
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enquiries';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string|class-string>
     */
    protected $casts = [
        'tenant' => Tenant::class,
        'widget' => Widget::class,
        'can_contact' => 'boolean',
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
