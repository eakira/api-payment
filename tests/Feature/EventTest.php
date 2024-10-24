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

    /**
     * Test retrieving the balance of an existing account.
     */
    public function test_get_balance_for_existing_account()
    {
        $this->postJson('/event', [
            'type' => 'deposit',
            'destination' => '100',
            'amount' => 20,
        ]);

        $response = $this->getJson('/balance?account_id=100');

        $response->assertStatus(200)
            ->assertExactJson(20);
    }

    /**
     * Test withdrawing from a non-existing account.
     */
    public function test_withdraw_from_non_existing_account()
    {
        $payload = [
            'type' => 'withdraw',
            'origin' => '200',
            'amount' => 10,
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(404)
            ->assertExactJson(0);
    }


    /**
     * Test withdrawing from a non-existing account.
     */
    public function test_with_invalid_request_in_event_route()
    {
        // Sending without the type
        $payload = [
            'origin' => '200',
            'amount' => 10,
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(404)
            ->assertExactJson(0);
    }
    /**
     * Test withdrawing from an existing account.
     */
    public function test_withdraw_from_existing_account()
    {
        $payload = [
            'type' => 'withdraw',
            'origin' => '100',
            'amount' => 5,
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'origin' => [
                    'id' => '100',
                    'balance' => 15,
                ],
            ]);

        $this->assertDatabaseHas('accounts', [
            'id' => '100',
            'balance' => 15,
        ]);
    }

    /**
     * Test transferring from an existing account to another.
     */
    public function test_transfer_from_existing_account()
    {
        // Perform the transfer
        $payload = [
            'type' => 'transfer',
            'origin' => '100',
            'amount' => 15,
            'destination' => '300',
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'origin' => [
                    'id' => '100',
                    'balance' => 0,
                ],
                'destination' => [
                    'id' => '300',
                    'balance' => 15,
                ],
            ]);

        // Verify that the accounts are updated in the database
        $this->assertDatabaseHas('accounts', [
            'id' => '100',
            'balance' => 0,
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => '300',
            'balance' => 15,
        ]);
    }

    /**
     * Test transferring from a non-existing account.
     */
    public function test_transfer_from_non_existing_account()
    {
        $payload = [
            'type' => 'transfer',
            'origin' => '200',
            'amount' => 15,
            'destination' => '300',
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(404)
            ->assertExactJson(0);
    }

    /**
     * Test transferring from an account with insufficient balance.
     */
    public function test_transfer_with_insufficient_balance()
    {
        $payload = [
            'type' => 'transfer',
            'origin' => '100',
            'amount' => 20,
            'destination' => '300',
        ];

        $response = $this->postJson('/event', $payload);

        $response->assertStatus(400)
            ->assertExactJson(0);
    }
}