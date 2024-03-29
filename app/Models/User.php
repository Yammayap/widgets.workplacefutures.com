<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @property int $id
 * @property string $uuid
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $company_name
 * @property PhoneNumber|null $phone
 * @property boolean $marketing_opt_in
 * @property boolean $has_completed_profile
 * @property string|null $remember_token
 *
 * @property-read string|null $name
 * @property-read Collection<int, Enquiry> $enquiries
 * @property-read Collection<int, MagicLink> $magicLinks
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasUuid;
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string|class-string>
     */
    protected $casts = [
        'marketing_opt_in'      => 'boolean',
        'has_completed_profile' => 'boolean',
        'phone'                 => E164PhoneNumberCast::class,
    ];

    /**
     * @return Attribute<string|null, never>
     */
    public function name(): Attribute
    {
        return new Attribute(
            get: function (): ?string {
                if ($this->first_name === null && $this->last_name === null) {
                    return null;
                }

                return trim($this->first_name . ' ' . $this->last_name);
            },
        );
    }

    /**
     * @return HasMany<Enquiry>
     */
    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'user_id');
    }

    /**
     * @return HasMany<MagicLink>
     */
    public function magicLinks(): HasMany
    {
        return $this->hasMany(MagicLink::class, 'user_id');
    }
}
