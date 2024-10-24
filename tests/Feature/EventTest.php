<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{

    use RefreshDatabase;

    /**
     *  Reset table a return a sucessful
     */
    public function test_the_reset_returns_a_successful_response(): void
    {
        $response = $this->post('/reset');

        $response->assertStatus(200);
    }

    /**
     * Test getting balance for a non-existing account.
     */
    public function test_get_balance_for_non_existing_account()
    {
        $response = $this->getJson('/balance?account_id=1234');

        $response->assertStatus(404)
            ->assertExactJson(0);
    }

    /**
     * Test creating an account with an initial balance.
     */
    public function test_create_account_with_initial_balance()
    {
        $payload = [
            'type' => 'deposit',
            'destination' => '100',
            'amount' => 10,
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'destination' => [
                    'id' => '100',
                    'balance' => 10,
                ],
            ]);

        $this->assertDatabaseHas('accounts', [
            'id' => '100',
            'balance' => 10,
        ]);
    }

    /**
     * Test depositing into an existing account.
     */
    public function test_deposit_into_existing_account()
    {
        $this->postJson('/event', [
            'type' => 'deposit',
            'destination' => '100',
            'amount' => 10,
        ]);

        $payload = [
            'type' => 'deposit',
            'destination' => '100',
            'amount' => 10,
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'destination' => [
                    'id' => '100',
                    'balance' => 20,
                ],
            ]);

        $this->assertDatabaseHas('accounts', [
            'id' => '100',
            'balance' => 20,
        ]);
    }

}