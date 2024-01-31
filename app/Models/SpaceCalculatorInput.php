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
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property int $enquiry_id
 * // todo: carry on setting up vars here when enums set up
 */
class SpaceCalculatorInput extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'space_calculator_inputs';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string|class-string>
     */
    protected $casts = [
        // todo: set up casts when enums set up
    ];

    /**
     * @return BelongsTo<Enquiry, self>
     */
    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'id', 'enquiry_id');
    }
}
