<?php

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\AddFullDetailsAction;
use App\Models\User;
use Tests\TestCase;

class AddFullDetailsActionTest extends TestCase
{
    public function test_enquiry_is_attached_to_a_user(): void
    {
        $user = User::factory()->create([
            'first_name' => null,
            'last_name' => null,
        ]);

        $this->assertNull($user->first_name);
        $this->assertNull($user->last_name);
        $this->assertNull($user->company_name);
        $this->assertNull($user->phone);
        $this->assertFalse($user->marketing_opt_in);

        AddFullDetailsAction::run(
            $user,
            'Liam',
            'Gallagher',
            'Oasis Ltd',
            '020 7963 1801',
            true,
        );

        $this->assertEquals('Liam', $user->first_name);
        $this->assertEquals('Gallagher', $user->last_name);
        $this->assertEquals('Oasis Ltd', $user->company_name);
        $this->assertEquals('+442079631801', $user->phone->formatE164());
        $this->assertTrue($user->marketing_opt_in);
    }
}
