<?php

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\UpdateProfileAction;
use App\Models\User;
use Propaganistas\LaravelPhone\PhoneNumber;
use Tests\TestCase;

class UpdateProfileActionTest extends TestCase
{
    public function test_user_profile_is_updated(): void
    {
        $user = User::factory()->create([
            'first_name' => null,
            'last_name' => null,
        ]);

        UpdateProfileAction::run(
            $user,
            'Liam',
            'Gallagher',
            'Oasis Ltd',
            new PhoneNumber('020 7963 1801', 'GB'),
            true,
        );

        $this->assertEquals('Liam', $user->first_name);
        $this->assertEquals('Gallagher', $user->last_name);
        $this->assertEquals('Oasis Ltd', $user->company_name);
        $this->assertEquals('+442079631801', $user->phone->formatE164());
        $this->assertTrue($user->marketing_opt_in);
        $this->assertTrue($user->has_completed_profile);
    }
}
