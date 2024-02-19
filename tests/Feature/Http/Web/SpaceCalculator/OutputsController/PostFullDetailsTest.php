<?php

namespace Tests\Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Tests\TestCase;

class PostFullDetailsTest extends TestCase
{
    public function test_posts_ok_with_minimal_data(): void
    {
        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.full-details.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher'
            ])
            ->assertRedirect(route('web.space-calculator.outputs.detailed', $inputs))
            ->assertSessionHasNoErrors();
    }

    /*
     * more...
     *
     * more data
     * required_fields
     * other errors (invalid phone, booleans)
     * auth_user_gets_redirected_away
     * without_session_redirects_away
     * try_to_access_results_for_inputs_when_different_uuid_is_in_session
     *
     */
}
