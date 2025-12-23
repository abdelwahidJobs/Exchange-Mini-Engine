<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class GetProfileTest extends TestCase
{


    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }



    /** @test */
    public function authenticated_user_can_get_his_profile_with_assets()
    {
        // Arrange: create user
        $user = User::factory()->create([
            'balance' => 10000,
        ]);

        // Arrange: create assets
        $user->assets()->create([
            'symbol' => 'BTC',
            'amount' => 1.5,
            'locked_amount' => 0.2,
        ]);

        $user->assets()->create([
            'symbol' => 'ETH',
            'amount' => 10,
            'locked_amount' => 0,
        ]);

        // Act: call API as authenticated user
        $response = $this
            ->actingAs($user, 'sanctum')
            ->getJson('/api/profile');

        // Assert: HTTP OK
        $response->assertOk();

        // Assert: JSON structure
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'balance',
                'assets' => [
                    '*' => [
                        'symbol',
                        'amount',
                        'locked_amount',
                    ],
                ],
            ],
        ]);
        // Assert: correct values
        $response->assertJson([
            'data' => [
                'balance' => 10000,
                'assets' => [
                    [
                        'symbol' => 'BTC',
                        'amount' => 1.5,
                        'locked_amount' => 0.2,
                    ],
                    [
                        'symbol' => 'ETH',
                        'amount' => 10,
                        'locked_amount' => 0,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_profile()
    {
        $this->getJson('/api/profile')
            ->assertUnauthorized();
    }

}
