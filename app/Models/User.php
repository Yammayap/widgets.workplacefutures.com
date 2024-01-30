<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @property int $id
 * @property string $uuid
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $company_name
 * @property PhoneNumber|null $phone
 * @property boolean $marketing_opt_in
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 */
class User extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string|class-string>
     */
    protected $casts = [ // todo: should phone also be casted? (We don't know a lot about the field yet)
        'marketing_opt_in' => 'boolean',
    ];
}
