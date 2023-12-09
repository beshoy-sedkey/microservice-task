<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testUserCreation()
    {
        $user = User::factory()->create();
        $faker = app(Faker::class);

        $response = $this->post('/api/register', [
            'name' => $user->name,
            'email' => $faker->unique()->safeEmail,
            'password' => '123456789',
        ]);

        $response->assertStatus(201);
    }
}
