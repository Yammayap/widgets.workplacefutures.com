<?php

namespace App\Models;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Traits\HasUuid;
use App\Services\SpaceCalculator\Inputs;
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
 * @property Workstyle $workstyle
 * @property int $total_people
 * @property int $growth_percentage
 * @property int $desk_percentage
 * @property HybridWorking $hybrid_working
 * @property Mobility $mobility
 * @property Collaboration $collaboration
 *
 * @property-read Enquiry $enquiry
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
        'workstyle' => Workstyle::class,
        'hybrid_working' => HybridWorking::class,
        'mobility' => Mobility::class,
        'collaboration' => Collaboration::class,
    ];

    /**
     * @return BelongsTo<Enquiry, self>
     */
    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id', 'id');
    }

    /**
     * @return Inputs
     */
    public function transformToCalculatorInputs(): Inputs
    {
        return new Inputs(
            workstyle: $this->workstyle,
            totalPeople: $this->total_people,
            growthPercentage: $this->growth_percentage,
            deskPercentage: $this->desk_percentage,
            hybridWorking: $this->hybrid_working,
            mobility: $this->mobility,
            collaboration: $this->collaboration,
        );
    }
}
